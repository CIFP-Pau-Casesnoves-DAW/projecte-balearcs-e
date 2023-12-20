<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntsInteres;

class PuntsInteresController extends Controller
{
    /**
     * Muestra una lista de todos los puntos de interés.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puntsInteres = PuntsInteres::all();
        return response()->json(['punts_interes' => $puntsInteres]);
    }

    /**
     * Almacena un nuevo punto de interés en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $puntInteres = PuntsInteres::create($request->all());

        return response()->json(['message' => 'Punto de interés creado correctamente', 'punt_interes' => $puntInteres]);
    }

    /**
     * Muestra el punto de interés especificado.
     *
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */
    public function show(PuntsInteres $puntInteres)
    {
        return response()->json(['punt_interes' => $puntInteres]);
    }

    /**
     * Actualiza el punto de interés especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PuntsInteres $puntInteres)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $puntInteres->update($request->all());

        return response()->json(['message' => 'Punto de interés actualizado correctamente', 'punt_interes' => $puntInteres]);
    }

    /**
     * Elimina el punto de interés especificado de la base de datos.
     *
     * @param  \App\Models\PuntsInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */
    public function destroy(PuntsInteres $puntInteres)
    {
        $puntInteres->delete();

        return response()->json(['message' => 'Punto de interés eliminado correctamente']);
    }
}
