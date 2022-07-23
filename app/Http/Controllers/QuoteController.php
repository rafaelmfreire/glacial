<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\ContractItem;
use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return inertia('Quotes/Index', [
            'quotes' => Quote::
            whereHas('quoteItems.airConditioner', function (Builder $query) use ($request) {
                $query->where('team_id', $request->user()->currentTeam->id);
            })
            ->get()
            ->each(function ($quote) {
                $quote->items = DB::table('quote_items')
                    ->select(DB::raw('count(quote_items.id) as items'))
                    ->where('quote_id', $quote->id)
                    ->first()->items;

                $quote->total = DB::table('quote_items')
                    ->join('contract_items', 'contract_items.id', '=', 'quote_items.contract_item_id')
                    ->select(DB::raw('sum(item_value * quantity) as total'))
                    ->where('quote_id', $quote->id)
                    ->first()->total / 100;
            })
            ->map(function ($quote) {
                return [
                    'id' => $quote->id,
                    'number' => $quote->number,
                    'date' => $quote->date,
                    'date_search' => $quote->date->format('Y-m-d'),
                    'date_formatted' => $quote->date->format('d/m/Y'),
                    'items' => $quote->items,
                    'total' => $quote->total
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
        return inertia('Quotes/Create');
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
            'number' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'contract_item_id' => ['required', 'exists:App\Models\ContractItem,number'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'service_date' => ['required', 'date'],
            'identifier' => ['required', 'exists:App\Models\AirConditioner,identifier'],
        ]);

        $airConditioner =  AirConditioner::where('identifier', $validated['identifier'])->first();

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
            'quantity' => $validated['quantity'],
            'service_date' => $validated['service_date']
        ]);
        
        $message = $validated['quantity'].' item '.$validated['contract_item_id'].' cadastrado no Orçamento '.$validated['number'].' para o aparelho '.$validated['identifier'];
        
        if ($validated['quantity'] > 1) {
            $message = $validated['quantity'].' itens '.$validated['contract_item_id'].' cadastrados no Orçamento '.$validated['number'].' para o aparelho '.$validated['identifier'];
        }

        $request->session()->flash('flash.banner', $message);

        if($request->page == 'airConditioner') {
            return Redirect::route('air_conditioners.show', $airConditioner);
        }

        return Redirect::route('quotes.create'); 
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
    public function destroy(AirConditioner $airConditioner, Quote $quote)
    {
        $quote->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
