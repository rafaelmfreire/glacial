<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\ContractItem;
use App\Models\Quote;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RequisitionController extends Controller
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
    public function store(AirConditioner $airConditioner, Request $request)
    {
        $validated = $request->validate([
            'number' => ['required', 'numeric'],
            'year' => ['required', 'numeric'],
            'contract_item_id' => ['required', 'exists:App\Models\ContractItem,number'],
            'quantity' => ['required', 'numeric'],
            'quote_number' => ['required', 'exists:App\Models\Quote,number']
        ]);

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
        
        // $validated['air_conditioner_id'] = $airConditioner->id;
        // $validated['contract_item_id'] = ContractItem::where('number', $validated['contract_item_id'])->first()->id;

        return Redirect::route('air_conditioners.show', $airConditioner);
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
        $requisition->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
