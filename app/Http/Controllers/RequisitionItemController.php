<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\QuoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class RequisitionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Requisition $requisition)
    {
        if (!Gate::allows('view-requisition-items', $requisition)) {
            abort(403);
        }

        $requisition->total = DB::table('requisition_items')
            ->join('contract_items', 'contract_items.id', '=', 'requisition_items.contract_item_id')
            ->select(DB::raw('sum(item_value * quantity) as total'))
            ->where('requisition_id', $requisition->id)
            ->first()->total / 100;

        return inertia('Requisitions/RequisitionItems/Index', [
            'air_conditioners' => AirConditioner::with([
                'requisitionItems' => function ($query) use ($requisition) {
                        $query->where('requisition_id', $requisition->id);
                    },
                'requisitionItems.contractItem', 
                'requisitionItems.quote',
                'brand'
            ])
            ->where('team_id', $request->user()->currentTeam->id)
            ->whereHas('requisitionItems', function (Builder $query) use ($requisition) {
                $query->where('requisition_id', $requisition->id);
            })
            ->get()
            ->map(function ($air_conditioner) use ($requisition) {
                return [
                    'id' => $air_conditioner->id,
                    'requisitionItems' => $air_conditioner->requisitionItems,
                    'room' => $air_conditioner->room,
                    'identifier' => $air_conditioner->identifier,
                    'cpf' => $air_conditioner->cpf,
                    'btu' => $air_conditioner->btu,
                    'brand' => $air_conditioner->brand->name,
                ];
            }),
            'requisition' => $requisition,
            'quote_items' => Inertia::lazy(
                fn () => QuoteItem::with(['contractItem'])->where(
                    'air_conditioner_id', $request->air_conditioner_id
                )->where(
                    'quote_id', $request->quote_id
                )->orderBy(
                    'service_date', 'asc'
                )->get()
            ),
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
    public function destroy(Requisition $requisition, RequisitionItem $requisitionItem)
    {
        $airConditioner = AirConditioner::where('id', $requisitionItem->air_conditioner_id)->first();

        $requisitionItem->delete();
        return Redirect::route('air_conditioners.show', $airConditioner);
    }
}
