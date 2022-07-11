<?php

namespace App\Http\Controllers;

use App\Models\AirConditioner;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AirConditionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $airConditioners = AirConditioner::with('brand')->get();

        return inertia('AirConditioners/Index', ['airConditioners' => AirConditioner::with('brand')->get()->map(function ($airConditioner) {
            return [
                'id' => $airConditioner->id,
                'room' => $airConditioner->room,
                'btu' => $airConditioner->btu,
                'identifier' => $airConditioner->identifier,
                'cpf' => $airConditioner->cpf,
                'brand' => $airConditioner->brand->name,
            ];
        })]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        return inertia('AirConditioners/Create', ['brands' => $brands]);
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
            'room' => ['required', 'string'],
            'btu' => ['nullable', 'numeric'],
            'identifier' => ['nullable', 'numeric'],
            'cpf' => ['nullable', 'string'],
            'brand_id' => ['required', 'exists:App\Models\Brand,id']
        ]);

        AirConditioner::create($validated);

        return Redirect::route('air_conditioners.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function show(AirConditioner $airConditioner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function edit(AirConditioner $airConditioner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AirConditioner $airConditioner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirConditioner  $airConditioner
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirConditioner $airConditioner)
    {
        //
    }
}
