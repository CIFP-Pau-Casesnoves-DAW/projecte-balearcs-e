<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesPuntsInteres;

/**
 * @OA\Tag(
 *     name="VisitesPuntsInteres",
 *     description="Operacions per a Visites Punts d'Interès"
 * )
 */
class VisitesPuntsInteresController extends Controller
{
    /**
     * Muestra una lista de todos los puntos de interés de una visita.
     *
     * @param  int  $visitaId
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/visites/{visitaId}/puntsinteres",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Llista tots els punts d'interès d'una visita",
     *     @OA\Parameter(
     *         name="visitaId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de punts d'interès per a la visita especificada",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/VisitesPuntsInteres")
     *         )
     *     )
     * )
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

     /**
     * @OA\Post(
     *     path="/api/visitespuntsinteres",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Crea una nova associació entre una visita i un punt d'interès",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VisitesPuntsInteres")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació entre la visita i el punt d'interès creada correctament"
     *     )
     * )
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

     /**
     * @OA\Get(
     *     path="/api/visites/{visitaId}/puntsinteres/{puntInteresId}",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Mostra una associació específica entre una visita i un punt d'interès",
     *     @OA\Parameter(
     *         name="visitaId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="puntInteresId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna l'associació específica entre la visita i el punt d'interès",
     *         @OA\JsonContent(ref="#/components/schemas/VisitesPuntsInteres")
     *     )
     * )
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

     /**
     * @OA\Delete(
     *     path="/api/visites/{visitaId}/puntsinteres/{puntInteresId}",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Elimina una associació específica entre una visita i un punt d'interès",
     *     @OA\Parameter(
     *         name="visitaId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="puntInteresId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació entre la visita i el punt d'interès eliminada correctament"
     *     )
     * )
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
