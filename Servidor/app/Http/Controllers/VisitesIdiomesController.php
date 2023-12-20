<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesIdiomes;

class VisitesIdiomesController extends Controller
{
    /**
     * Muestra una lista de todas las traducciones de visitas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitesIdiomes = VisitesIdiomes::all();
        return response()->json(['visites_idiomes' => $visitesIdiomes]);
    }

    /**
     * Almacena una nueva traducción de visita en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'visita_id' => 'required|exists:visites,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaIdioma = VisitesIdiomes::create($request->all());

        return response()->json(['message' => 'Traducción de visita creada correctamente', 'visita_idioma' => $visitaIdioma]);
    }

    /**
     * Muestra la traducción de visita especificada.
     *
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */
    public function show(VisitesIdiomes $visitaIdioma)
    {
        return response()->json(['visita_idioma' => $visitaIdioma]);
    }

    /**
     * Actualiza la traducción de visita especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisitesIdiomes $visitaIdioma)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'visita_id' => 'required|exists:visites,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaIdioma->update($request->all());

        return response()->json(['message' => 'Traducción de visita actualizada correctamente', 'visita_idioma' => $visitaIdioma]);
    }

    /**
     * Elimina la traducción de visita especificada de la base de datos.
     *
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitesIdiomes $visitaIdioma)
    {
        $visitaIdioma->delete();

        return response()->json(['message' => 'Traducción de visita eliminada correctamente']);
    }
}
