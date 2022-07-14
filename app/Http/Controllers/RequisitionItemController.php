<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RequisitionItemController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequisitionItem  $requisitionItem
     * @return \Illuminate\Http\Response
     */
    public function show(RequisitionItem $requisitionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequisitionItem  $requisitionItem
     * @return \Illuminate\Http\Response
     */
    public function edit(RequisitionItem $requisitionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequisitionItem  $requisitionItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequisitionItem $requisitionItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequisitionItem  $requisitionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirConditioner $airConditioner, Requisition $requisition, RequisitionItem $requisitionItem)
    {
        $requisitionItem->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
