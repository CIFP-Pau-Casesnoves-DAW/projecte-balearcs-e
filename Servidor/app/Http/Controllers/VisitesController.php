<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visites;

class VisitesController extends Controller
{
    /**
     * Muestra una lista de todas las visitas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visites = Visites::all();
        return response()->json(['visites' => $visites]);
    }

    /**
     * Almacena una nueva visita en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'inscripcio_previa' => 'required|boolean',
            'n_places' => 'required|integer',
            'total_visitants' => 'nullable|integer',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date',
            'horari' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $visita = Visites::create($request->all());

        return response()->json(['message' => 'Visita creada correctamente', 'visita' => $visita]);
    }

    /**
     * Muestra la visita especificada.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visites $visita)
    {
        return response()->json(['visita' => $visita]);
    }

    /**
     * Actualiza la visita especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visites $visita)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'inscripcio_previa' => 'required|boolean',
            'n_places' => 'required|integer',
            'total_visitants' => 'nullable|integer',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date',
            'horari' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $visita->update($request->all());

        return response()->json(['message' => 'Visita actualizada correctamente', 'visita' => $visita]);
    }

    /**
     * Elimina la visita especificada de la base de datos.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visites $visita)
    {
        $visita->delete();

        return response()->json(['message' => 'Visita eliminada correctamente']);
    }
}
