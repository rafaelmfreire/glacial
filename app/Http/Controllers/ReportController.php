<?php

namespace App\Http\Controllers;

use App\Models\Brand;
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
}
