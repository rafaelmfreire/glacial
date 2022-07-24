<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class QuoteItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quote $quote)
    {
        if (!Gate::allows('view-quote-items', $quote)) {
            abort(403);
        }

        $quote->total = DB::table('quote_items')
            ->join('contract_items', 'contract_items.id', '=', 'quote_items.contract_item_id')
            ->select(DB::raw('sum(item_value * quantity) as total'))
            ->where('quote_id', $quote->id)
            ->first()->total / 100;

        return inertia('Reports/Quotes/QuoteItems', [
            'air_conditioners' => AirConditioner::with([
                'quoteItems' => function ($query) use ($quote) {
                        $query->where('quote_id', $quote->id);
                    },
                'quoteItems.contractItem', 
                'brand'
            ])
            ->where('team_id', $request->user()->currentTeam->id)
            ->whereHas('quoteItems', function (Builder $query) use ($quote) {
                $query->where('quote_id', $quote->id);
            })
            ->get()
            ->map(function ($air_conditioner) use ($quote) {
                return [
                    'id' => $air_conditioner->id,
                    'quoteItems' => $air_conditioner->quoteItems,
                    'room' => $air_conditioner->room,
                    'identifier' => $air_conditioner->identifier,
                    'cpf' => $air_conditioner->cpf,
                    'btu' => $air_conditioner->btu,
                    'brand' => $air_conditioner->brand->name,
                ];
            }),
            'quote' => $quote,
            'service_orders' => Inertia::lazy(fn () => ServiceOrder::where('air_conditioner_id', $request->air_conditioner)->orderBy('done_at', 'desc')->get()->each(function ($serviceOrder) {
                $difference = $serviceOrder->done_at->diffInDays();
                $serviceOrder->date_diff = $difference == 0 ? 'hoje' : ($difference == 1 ? 'ontem' : 'há '.$difference.' dias');
                $serviceOrder->done_date = $serviceOrder->done_at->format('d/m/Y H:i');
                $serviceOrder->status_name = $serviceOrder->statusName;
                $serviceOrder->status_abbr = $serviceOrder->statusAbbr;
            }))
        ]);
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
    public function destroy(Quote $quote, QuoteItem $quoteItem)
    {
        $airConditioner = AirConditioner::where('id', $quoteItem->air_conditioner_id)->first();

        $quoteItem->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
