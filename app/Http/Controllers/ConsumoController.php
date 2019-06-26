<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consumo;
use Illuminate\Support\Facades\Auth;


class ConsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $consumos = Consumos::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
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
        $consumo = new Consumo();
        $consumo->fecha = $request->fecha;
        $consumo->datos_consumo = $request->datos_consumo;
        $consumo->contratista_id = $request->contratista_id;
        $consumo->added_by = Auth::user()->name;
        $consumo->save();
        $consumo->contratista()->attach($request->contratista_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $consumo = Consumo::findOrFail($request->id);
        $consumo->fecha = $request->fecha;
        $consumo->datos_consumo = $request->datos_consumo;
        $consumo->contratista_id = $request->contratista_id;
        $consumo->added_by = Auth::user()->name;
        $consumo->save();

        $consumo->contratista()->detach();
        $consumo->contratista()->attach($request->contratista_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $consumo = Consumo::findOrFail($id);
        $consumo->contratista()->detach();
        $consumo->delete();

    }

    public function getConsumeByDate(Request $request){

        $contratista = $request->query('contr_id');
        $date1 = date('Y-m-d', strtotime($request->query('start')));
        $date2 = date('Y-m-d', strtotime($request->query('end')));
        
            
            
            if($contratista != 'undefined'){
                $consumos = Consumo::with('contratista')
                    ->whereBetween('fecha', [$date1, $date2])
                    ->where('contratista_id', $contratista)->get();
            return $consumos;
                    
            }
            else{
                $consumos = Consumo::with('contratista')
                    ->whereBetween('fecha', [$date1, $date2])->get();

                return $consumos;
            }
  
    }

    public function getSingleContratistaConsumo($month, $contratista){
        $consumos = Consumo::with('contratista')
            ->where('contratista_id', $contratista)
            ->whereMonth('fecha', $month)
            ->get();

        return $consumos;
    }

    public function getContratistasConsumos($month)
    {
        $consumos = Consumo::with('contratista')
            ->whereMonth('fecha', $month)
            ->get();

        return $consumos;
    }
}
