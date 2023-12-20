<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesPuntsInteres;

class VisitesPuntsInteresController extends Controller
{
    /**
     * Muestra una lista de todos los puntos de interés de una visita.
     *
     * @param  int  $visitaId
     * @return \Illuminate\Http\Response
     */
    public function index($visitaId)
    {
        $puntsInteres = VisitesPuntsInteres::where('visita_id', $visitaId)->get();
        return response()->json(['punts_interes' => $puntsInteres]);
    }

    /**
     * Asocia un punto de interés a una visita.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'punts_interes_id' => 'required|exists:punts_interes,id',
            'visita_id' => 'required|exists:visites,id',
            'ordre' => 'required|integer',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaPuntInteres = VisitesPuntsInteres::create($request->all());

        return response()->json(['message' => 'Punto de interés asociado a la visita correctamente', 'visita_punt_interes' => $visitaPuntInteres]);
    }

    /**
     * Muestra la asociación de punto de interés específica.
     *
     * @param  int  $visitaId
     * @param  int  $puntInteresId
     * @return \Illuminate\Http\Response
     */
    public function show($visitaId, $puntInteresId)
    {
        $visitaPuntInteres = VisitesPuntsInteres::where('visita_id', $visitaId)->where('punts_interes_id', $puntInteresId)->first();
        return response()->json(['visita_punt_interes' => $visitaPuntInteres]);
    }

    /**
     * Desasocia un punto de interés de una visita.
     *
     * @param  int  $visitaId
     * @param  int  $puntInteresId
     * @return \Illuminate\Http\Response
     */
    public function destroy($visitaId, $puntInteresId)
    {
        $visitaPuntInteres = VisitesPuntsInteres::where('visita_id', $visitaId)->where('punts_interes_id', $puntInteresId)->first();

        if ($visitaPuntInteres) {
            $visitaPuntInteres->delete();
            return response()->json(['message' => 'Punto de interés desasociado de la visita correctamente']);
        } else {
            return response()->json(['message' => 'No se encontró la asociación de punto de interés con la visita'], 404);
        }
    }
}
