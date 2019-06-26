<?php

namespace App\Http\Controllers;

use App\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $consumos = Equipo::all();
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
        $equipos = new Equipo();
        $equipos->fecha = $request->fecha;
        $equipos->datos_equipos = $request->datos_equipos;
        $equipos->contratista_id = $request->contratista_id;
        $equipos->added_by = Auth::user()->name;
        $equipos->save();
        $equipos->contratista()->attach($request->contratista_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function show(Equipo $equipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipo $equipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipo $equipo)
    {
        $equipos = Equipo::findOrFail($request->id);
        $equipos->fecha = $request->fecha;
        $equipos->datos_consumo = $request->datos_equipos;
        $equipos->contratista_id = $request->contratista_id;
        $equipos->added_by = Auth::user()->name;
        $equipos->save();
        $equipos->contratista()->detach();
        $equipos->contratista()->attach($request->contratista_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipo  $equipo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $equipos = Equipo::findOrFail($id);
        $equipos->delete();

    }
}
