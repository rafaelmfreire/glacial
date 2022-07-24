<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOrderStatus;
use App\Models\AirConditioner;
use App\Models\Brand;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Enum;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = Brand::all();
        $statusArray = [];
        foreach (ServiceOrderStatus::cases() as $key => $status) {
            $statusArray[__('messages.status.'.$status->name)] = $status->value;
        }

        return inertia('ServiceOrders/Index', [
            'service_orders' => ServiceOrder::with('airConditioner', 'airConditioner.brand')
            ->whereHas('airConditioner', function (Builder $query) use ($request) {
                $query->where('team_id', $request->user()->currentTeam->id);
            })
            ->get()
            ->map(function ($service_order) {
                return [
                    'id' => $service_order->id,
                    'identifier' => $service_order->airConditioner->identifier,
                    'air_conditioner_id' => $service_order->airConditioner->id,
                    'room' => $service_order->airConditioner->room,
                    'btu' => $service_order->airConditioner->btu,
                    'cpf' => $service_order->airConditioner->cpf,
                    'brand' => $service_order->airConditioner->brand->name,
                    'brand_id' => $service_order->airConditioner->brand->id,
                    'done_at' => $service_order->done_at,
                    'done_at_search' => $service_order->done_at->format('Y-m-d'),
                    'done_at_formatted' => $service_order->done_at->format('d/m/Y'),
                    'done_at_time' => $service_order->done_at_time,
                    'services' => $service_order->services,
                    'technicians' => $service_order->technicians,
                    'status' => $service_order->status,
                    'status_abbr' => $service_order->status_abbr,
                ];
            }),
            'brands' => $brands,
            'statuses' => $statusArray
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusArray = [];
        foreach (ServiceOrderStatus::cases() as $key => $status) {
            $statusArray[__('messages.status.'.$status->name)] = $status->value;
        }
        return inertia('ServiceOrders/Create', ['statuses' => $statusArray]);
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
            'services' => ['required', 'string'],
            'technicians' => ['required', 'string'],
            'done_at' => ['required', 'date'],
            'done_at_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', new Enum(ServiceOrderStatus::class)],
            'identifier' => ['required', 'exists:App\Models\AirConditioner,identifier'],
        ]);

        $airConditioner =  AirConditioner::where('identifier', $validated['identifier'])->first();

        ServiceOrder::create([
            'services' => $validated['services'],
            'technicians' => $validated['technicians'],
            'done_at' => $validated['done_at'].' '.$validated['done_at_time'],
            'status' => $validated['status'],
            'air_conditioner_id' => AirConditioner::where('identifier', $validated['identifier'])->first()->id
        ]);

        $done_at_formatted = Carbon::createFromFormat('Y-m-d', $validated['done_at'])->format('d/m/Y');
        $request->session()->flash('flash.banner', 'Serviço cadastrado para a máquina '.$validated['identifier'].' no dia '.$done_at_formatted.' às '.$validated['done_at_time'].'!');

        if($request->page == 'airConditioner') {
            return Redirect::route('air_conditioners.show', $airConditioner);
        }
        return Redirect::route('service_orders.create'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $serviceOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        $airConditioner = AirConditioner::where('id', $serviceOrder->air_conditioner_id)->first();

        $serviceOrder->delete();

        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
