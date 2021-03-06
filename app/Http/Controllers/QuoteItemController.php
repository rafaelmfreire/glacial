<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuoteItemController extends Controller
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
     * @param  \App\Models\QuoteItem  $quoteItem
     * @return \Illuminate\Http\Response
     */
    public function show(QuoteItem $quoteItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuoteItem  $quoteItem
     * @return \Illuminate\Http\Response
     */
    public function edit(QuoteItem $quoteItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuoteItem  $quoteItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuoteItem $quoteItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuoteItem  $quoteItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirConditioner $airConditioner, Quote $quote, QuoteItem $quoteItem)
    {
        $quoteItem->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
