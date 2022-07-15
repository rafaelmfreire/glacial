<?php

namespace App\Http\Controllers;

use App\Enums\ServiceOrderStatus;
use App\Models\Brand;
use App\Models\ServiceOrder;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
            'service_orders' => ServiceOrder::with('airConditioner', 'airConditioner.brand')->get()->map(function ($service_order) {
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
}
