<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOrderStatus;
use App\Models\AirConditioner;
use App\Models\Brand;
use App\Models\Quote;
use App\Models\Requisition;
use App\Models\ServiceOrder;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class AirConditionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = Brand::all();

        return inertia('AirConditioners/Index', [
            'airConditioners' => AirConditioner::with('brand')->where('team_id', $request->user()->currentTeam->id)->get()->map(function ($airConditioner) {
                return [
                    'id' => $airConditioner->id,
                    'room' => $airConditioner->room,
                    'btu' => $airConditioner->btu,
                    'identifier' => $airConditioner->identifier,
                    'cpf' => $airConditioner->cpf,
                    'brand' => $airConditioner->brand->name,
                    'brand_id' => $airConditioner->brand->id,
                ];
            }),
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        return inertia('AirConditioners/Create', ['brands' => $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room' => ['required', 'string'],
            'btu' => ['nullable', 'numeric'],
            'identifier' => ['nullable', 'digits_between:4,10', 'numeric'],
            'cpf' => ['nullable', 'string'],
            'brand_id' => ['required', 'exists:App\Models\Brand,id']
        ]);
        
        $validated['team_id'] = $request->user()->currentTeam->id;

        AirConditioner::create($validated);

        return Redirect::route('air_conditioners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function show(AirConditioner $airConditioner)
    {
        if (!Gate::allows('view-air-conditioner', $airConditioner)) {
            abort(403);
        }

        $tickets = Ticket::where('air_conditioner_id', $airConditioner->id)->orderBy('opened_at', 'desc')->get()->each(function ($ticket) {
            $difference = $ticket->opened_at->diffInDays();
            $ticket->date_diff = $difference == 0 ? 'hoje' : ($difference == 1 ? 'ontem' : 'há '.$difference.' dias');
            $ticket->opened_date = $ticket->opened_at->format('d/m/Y');
        });

        $serviceOrders = ServiceOrder::where('air_conditioner_id', $airConditioner->id)->orderBy('done_at', 'desc')->get()->each(function ($serviceOrder) {
            $difference = $serviceOrder->done_at->diffInDays();
            $serviceOrder->date_diff = $difference == 0 ? 'hoje' : ($difference == 1 ? 'ontem' : 'há '.$difference.' dias');
            $serviceOrder->done_date = $serviceOrder->done_at->format('d/m/Y H:i');
            $serviceOrder->status_name = $serviceOrder->statusName;
            $serviceOrder->status_abbr = $serviceOrder->statusAbbr;
        });

        $quotes = Quote::
            with([
                'quoteItems' => function ($query) use ($airConditioner) {
                    $query->where('air_conditioner_id', $airConditioner->id);
                },
                'quoteItems.contractItem'
            ])
            ->whereHas('quoteItems', function (Builder $query) use ($airConditioner) {
                $query->where('air_conditioner_id', $airConditioner->id);
            })
            ->orderBy('date', 'desc')
            ->orderBy('number', 'desc')
            ->get()
            ->each(function ($quote) use ($airConditioner) {
                $quote->date_formatted = $quote->date->format('d/m/Y');
                $quote->total = DB::table('quote_items')
                    ->join('contract_items', 'contract_items.id', '=', 'quote_items.contract_item_id')
                    ->select(DB::raw('sum(item_value * quantity) as total'))
                    ->where('quote_id', $quote->id)
                    ->where('air_conditioner_id', $airConditioner->id)
                    ->first()->total / 100;
        });

        $requisitions = Requisition::
            with([
                'requisitionItems' => function ($query) use ($airConditioner) {
                    $query->where('air_conditioner_id', $airConditioner->id);
                },
                'requisitionItems.contractItem',
                'requisitionItems.quote'
            ])
            ->whereHas('requisitionItems', function (Builder $query) use ($airConditioner) {
                $query->where('air_conditioner_id', $airConditioner->id);
            })
            ->orderBy('year', 'desc')
            ->orderBy('number', 'desc')
            ->get()
            ->each(function ($requisition) use ($airConditioner) {
                $requisition->total = DB::table('requisition_items')
                    ->join('contract_items', 'contract_items.id', '=', 'requisition_items.contract_item_id')
                    ->select(DB::raw('sum(item_value * quantity) as total'))
                    ->where('requisition_id', $requisition->id)
                    ->where('air_conditioner_id', $airConditioner->id)
                    ->first()->total / 100;
            });

        $statusArray = [];
        foreach (ServiceOrderStatus::cases() as $key => $status) {
            $statusArray[__('messages.status.'.$status->name)] = $status->value;
        }

        return inertia('AirConditioners/Show', [
            'airConditioner' => [
                'id'            => $airConditioner->id,
                'room'          => $airConditioner->room,
                'btu'           => $airConditioner->btu,
                'identifier'    => $airConditioner->identifier,
                'cpf'           => $airConditioner->cpf,
                'brand'         => $airConditioner->brand->name,
                'brand_id'      => $airConditioner->brand->id,
                'tickets'       => $tickets,
                'serviceOrders' => $serviceOrders,
                'quotes'        => $quotes,
                'requisitions'  => $requisitions
            ],
            'statuses' => $statusArray
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function edit(AirConditioner $airConditioner)
    {
        if (!Gate::allows('view-air-conditioner', $airConditioner)) {
            abort(403);
        }

        $brands = Brand::all();

        return inertia('AirConditioners/Edit', [
            'airConditioner' => [
                'id' => $airConditioner->id,
                'room' => $airConditioner->room,
                'btu' => $airConditioner->btu,
                'identifier' => $airConditioner->identifier,
                'cpf' => $airConditioner->cpf,
                'brand_id' => $airConditioner->brand->id,
            ],
            'brands' => $brands
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AirConditioner $airConditioner)
    {
        $validated = $request->validate([
            'room' => ['required', 'string'],
            'btu' => ['nullable', 'numeric'],
            'identifier' => ['nullable', 'numeric'],
            'cpf' => ['nullable', 'string'],
            'brand_id' => ['required', 'exists:App\Models\Brand,id']
        ]);

        $airConditioner->room = $validated['room'];
        $airConditioner->btu = $validated['btu'];
        $airConditioner->identifier = $validated['identifier'];
        $airConditioner->cpf = $validated['cpf'];
        $airConditioner->brand_id = $validated['brand_id'];

        $airConditioner->save();

        return Redirect::route('air_conditioners.show', $airConditioner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirConditioner $airConditioner)
    {
        //
    }
}
