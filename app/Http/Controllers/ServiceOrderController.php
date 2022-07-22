<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOrderStatus;
use App\Models\AirConditioner;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Enum;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AirConditioner $airConditioner)
    {
        $validated = $request->validate([
            'services' => ['required', 'string'],
            'technicians' => ['required', 'string'],
            'done_at' => ['required', 'date'],
            'status' => ['required', new Enum(ServiceOrderStatus::class)]
        ]);

        $validated['air_conditioner_id'] = $airConditioner->id;

        ServiceOrder::create($validated);

        return Redirect::route('air_conditioners.show', $airConditioner);
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
    public function destroy(AirConditioner $airConditioner, ServiceOrder $serviceOrder)
    {
        $serviceOrder->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
