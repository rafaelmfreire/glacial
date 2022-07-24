<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\ContractItem;
use App\Models\Quote;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Requisitions/Index', [
            'requisitions' => Requisition::
            whereHas('requisitionItems.airConditioner', function (Builder $query) use ($request) {
                $query->where('team_id', $request->user()->currentTeam->id);
            })
            ->get()
            ->each(function ($requisition) {
                $requisition->items = DB::table('requisition_items')
                    ->select(DB::raw('count(requisition_items.id) as items'))
                    ->where('requisition_id', $requisition->id)
                    ->first()->items;

                $requisition->total = DB::table('requisition_items')
                    ->join('contract_items', 'contract_items.id', '=', 'requisition_items.contract_item_id')
                    ->select(DB::raw('sum(item_value * quantity) as total'))
                    ->where('requisition_id', $requisition->id)
                    ->first()->total / 100;
            })
            ->map(function ($requisition) {
                return [
                    'id' => $requisition->id,
                    'number' => $requisition->number,
                    'year' => $requisition->year,
                    'items' => $requisition->items,
                    'total' => $requisition->total
                ];
            }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Requisitions/Create');
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
            'number' => ['required', 'numeric', 'min:1'],
            'year' => ['required', 'numeric', 'min:1'],
            'contract_item_id' => ['required', 'exists:App\Models\ContractItem,number'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'quote_number' => ['required', 'exists:App\Models\Quote,number'],
            'identifier' => ['required', 'exists:App\Models\AirConditioner,identifier'],
        ]);

        $airConditioner =  AirConditioner::where('identifier', $validated['identifier'])->first();

        $transaction = DB::transaction(function () use ($validated, $airConditioner) {
            $requisition = Requisition::where('number', '=', $validated['number'])->where('year', '=', $validated['year'])->firstOrCreate(
                [
                'number' => $validated['number'],
                'year' => $validated['year'],
                ],
            );
            $quote = Quote::where('number', '=', $validated['quote_number'])->first();

            RequisitionItem::create([
                'requisition_id' => $requisition->id,
                'air_conditioner_id' => $airConditioner->id,
                'contract_item_id' => ContractItem::where('number', $validated['contract_item_id'])->first()->id,
                'quantity' => $validated['quantity'],
                'quote_id' => $quote->id
            ]);
        });
        
        $message = $validated['quantity'].' item '.$validated['contract_item_id'].' cadastrado na Requisição '.$validated['number'].'/'.$validated['year'].' para o aparelho '.$validated['identifier'];
        
        if ($validated['quantity'] > 1) {
            $message = $validated['quantity'].' itens '.$validated['contract_item_id'].' cadastrados na Requisição '.$validated['number'].'/'.$validated['year'].' para o aparelho '.$validated['identifier'];
        }

        $request->session()->flash('flash.banner', $message);

        if($request->page == 'airConditioner') {
            return Redirect::route('air_conditioners.show', $airConditioner);
        }

        return Redirect::route('requisitions.create'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisition $requisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirConditioner $airConditioner, Requisition $requisition)
    {
        // TODO: requisitions can only be deleted when there hasn't requisition_items. Only admins can see and delete requisitions that doesn't have requisition_items

        // $requisition->delete();
        // return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
