<?php

namespace App\Http\Controllers;

use App\Contratista;
use Illuminate\Http\Request;

class ContratistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $contratistas = Contratista::all();
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
        $contratista = new Contratista();

        $contratista->nombre = $request->nombre;
        $contratista->centro_SAP = $request->centro_SAP;
        $contratista->almacen_SAP = $request->almacen_SAP;
        $contratista->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contratista  $contratista
     * @return \Illuminate\Http\Response
     */
    public function show(Contratista $contratista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contratista  $contratista
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratista $contratista)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contratista  $contratista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $contratista = Contratista::findOrFail($request->id);
        $contratista->nombre = $request->nombre;
        $contratista->centro_SAP = $request->centro_SAP;
        $contratista->almacen_SAP = $request->almacen_SAP;
        $contratista->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contratista  $contratista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contratista = Contratista::findOrFail($id);
        $contratista->delete();
    }
}
