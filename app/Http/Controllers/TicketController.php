<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Brand;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = Brand::all();

        return inertia('Tickets/Index', [
            'tickets' => Ticket::with([
                'airConditioner',
                'airConditioner.latestServiceOrder', 
                'airConditioner.brand'
            ])
            ->whereHas('airConditioner', function (Builder $query) use ($request) {
                $query->where('team_id', $request->user()->currentTeam->id);
            })
            ->get()->map(function ($ticket) {
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
                    'latest_service_order' => $ticket->airConditioner->latestServiceOrder
                ];
            }),
            'brands' => $brands
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Tickets/Create');
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
            'problem' => ['required', 'string'],
            'informed_by' => ['nullable', 'string'],
            'opened_at' => ['required', 'date'],
            'identifier' => ['required', 'exists:App\Models\AirConditioner,identifier'],
        ]);

        $airConditioner =  AirConditioner::where('identifier', $validated['identifier'])->first();

        Ticket::create([
            'air_conditioner_id' => $airConditioner->id,
            'problem'            => $validated['problem'],
            'informed_by'        => $validated['informed_by'],
            'opened_at'          => $validated['opened_at'],
        ]);

        $request->session()->flash('flash.banner', 'Chamado "'.$validated['problem'].'" cadastrado para o aparelho '.$validated['identifier']);
        $request->session()->flash('flash.bannerStyle', 'success');

        if($request->page == 'airConditioner') {
            return Redirect::route('air_conditioners.show', $airConditioner);
        }
        return Redirect::route('tickets.create'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ticket $ticket)
    {
        $airConditioner = AirConditioner::where('id', $ticket->air_conditioner_id)->first();
        $ticket->delete();
        $request->session()->flash('flash.banner', 'Chamado excluído!');
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
