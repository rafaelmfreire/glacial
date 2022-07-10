<?php

namespace App\Http\Controllers;

use App\Models\ContractItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContractItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractItems = ContractItem::all();

        return inertia('ContractItems/Index', ['contractItems' => $contractItems]);
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
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'number' => ['required', 'string'],
            'item_value' => ['required', 'numeric'],
        ]);

        ContractItem::create($validated);

        return Redirect::route('contract_items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContractItem  $contractItem
     * @return \Illuminate\Http\Response
     */
    public function show(ContractItem $contractItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractItem  $contractItem
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractItem $contractItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractItem  $contractItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractItem $contractItem)
    {
        $validated = $request->validate([
            'title' => ['required', 'string'],
            'number' => ['required', 'string'],
            'item_value' => ['required', 'numeric'],
        ]);

        $contractItem->title = $validated['title'];
        $contractItem->number = $validated['number'];
        $contractItem->item_value = $validated['item_value'];

        $contractItem->save();

        return Redirect::route('contract_items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractItem  $contractItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractItem $contractItem)
    {
        //
    }
}
