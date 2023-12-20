<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServeisIdiomes;

class ServeisIdiomesController extends Controller
{
    /**
     * Muestra una lista de todas las traducciones de servicios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serveisIdiomes = ServeisIdiomes::all();
        return response()->json(['serveis_idiomes' => $serveisIdiomes]);
    }

    /**
     * Almacena una nueva traducción de servicio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'servei_id' => 'required|exists:serveis,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $serveiIdioma = ServeisIdiomes::create($request->all());

        return response()->json(['message' => 'Traducción de servicio creada correctamente', 'servei_idioma' => $serveiIdioma]);
    }

    /**
     * Muestra la traducción de servicio especificada.
     *
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */
    public function show(ServeisIdiomes $serveisIdioma)
    {
        return response()->json(['servei_idioma' => $serveisIdioma]);
    }

    /**
     * Actualiza la traducción de servicio especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServeisIdiomes $serveisIdioma)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'servei_id' => 'required|exists:serveis,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $serveisIdioma->update($request->all());

        return response()->json(['message' => 'Traducción de servicio actualizada correctamente', 'servei_idioma' => $serveisIdioma]);
    }

    /**
     * Elimina la traducción de servicio especificada de la base de datos.
     *
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServeisIdiomes $serveisIdioma)
    {
        $serveisIdioma->delete();

        return response()->json(['message' => 'Traducción de servicio eliminada correctamente']);
    }
}
