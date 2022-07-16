<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOrderStatus;
use App\Models\AirConditioner;
use App\Models\Brand;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\ServiceOrder;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function tickets()
    {
        $brands = Brand::all();

        return inertia('Reports/Tickets', [
            'tickets' => Ticket::with('airConditioner', 'airConditioner.brand')->get()->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'air_conditioner_id' => $ticket->airConditioner->id,
                    'identifier' => $ticket->airConditioner->identifier,
                    'room' => $ticket->airConditioner->room,
                    'btu' => $ticket->airConditioner->btu,
                    'cpf' => $ticket->airConditioner->cpf,
                    'brand' => $ticket->airConditioner->brand->name,
                    'brand_id' => $ticket->airConditioner->brand->id,
                    'opened_at' => $ticket->opened_at,
                    'opened_at_search' => $ticket->opened_at->format('Y-m-d'),
                    'opened_at_formatted' => $ticket->opened_at->format('d/m/Y'),
                    'problem' => $ticket->problem,
                    'informed_by' => $ticket->informed_by,
                ];
            }),
            'brands' => $brands
        ]);
    }

    public function service_orders()
    {
        $brands = Brand::all();
        $statusArray = [];
        foreach (ServiceOrderStatus::cases() as $key => $status) {
            $statusArray[__('messages.status.'.$status->name)] = $status->value;
        }

        return inertia('Reports/ServiceOrders', [
            'service_orders' => ServiceOrder::with('airConditioner', 'airConditioner.brand')->get()
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

    public function quotes()
    {
        return inertia('Reports/Quotes', [
            'quotes' => Quote::all()
            ->each(function ($quote) {
                $quote->items = DB::table('quote_items')
                    ->select(DB::raw('count(quote_items.id) as items'))
                    ->where('quote_id', $quote->id)
                    ->first()->items;
            })
            ->map(function ($quote) {
                return [
                    'id' => $quote->id,
                    'number' => $quote->number,
                    'date' => $quote->date,
                    'date_search' => $quote->date->format('Y-m-d'),
                    'date_formatted' => $quote->date->format('d/m/Y'),
                    'items' => $quote->items
                ];
            }),
        ]);
    }

    public function quote_items(Quote $quote, Request $request)
    {
        return inertia('Reports/Quotes/QuoteItems', [
            'air_conditioners' => AirConditioner::with([
                'quoteItems' => function ($query) use ($quote) {
                        $query->where('quote_id', $quote->id);
                    },
                'quoteItems.contractItem', 
                'brand'
            ])
            ->wherehas('quoteItems', function (Builder $query) use ($quote) {
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
}
