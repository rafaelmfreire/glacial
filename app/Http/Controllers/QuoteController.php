<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\ContractItem;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuoteController extends Controller
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
            'number' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'contract_item_id' => ['required', 'exists:App\Models\ContractItem,number'],
            'quantity' => ['required', 'numeric']
        ]);

        $quote = Quote::where('number', '=', $validated['number'])->firstOrCreate(
            [
            'number' => $validated['number'],
            ],
            [
                'date'   => $validated['date'],
            ]
        );

        QuoteItem::create([
            'quote_id' => $quote->id,
            'air_conditioner_id' => $airConditioner->id,
            'contract_item_id' => ContractItem::where('number', $validated['contract_item_id'])->first()->id,
            'quantity' => $validated['quantity']
        ]);
        
        // $validated['air_conditioner_id'] = $airConditioner->id;
        // $validated['contract_item_id'] = ContractItem::where('number', $validated['contract_item_id'])->first()->id;

        return Redirect::route('air_conditioners.show', $airConditioner);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
