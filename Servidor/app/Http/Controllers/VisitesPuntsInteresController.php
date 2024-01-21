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
 *     path="/visitespuntsinteres/{visitaId}",
 *     summary="Llista tots els punts d'interès d'una visita específica",
 *     tags={"VisitesPuntsInteres"},
 *     @OA\Parameter(
 *         name="visitaId",
 *         in="path",
 *         required=true,
 *         description="ID de la visita",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna un llistat de tots els punts d'interès associats amb la visita",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/VisitesPuntsInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita no encontrada")
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *    schema="VisitesPuntsInteres",
 *    type="object",
 *    @OA\Property(property="id", type="integer"),
 *    @OA\Property(property="visita_id", type="integer"),
 *    @OA\Property(property="punts_interes_id", type="integer"),
 *    @OA\Property(property="ordre", type="integer"),
 *    @OA\Property(property="data_baixa", type="string", format="date", nullable=true),
 *    
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
 *     path="/visitespuntsinteres",
 *     summary="Associa un punt d'interès amb una visita",
 *     tags={"VisitesPuntsInteres"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a associar el punt d'interès amb la visita",
 *         @OA\JsonContent(
 *             required={"punts_interes_id", "visita_id", "ordre"},
 *             @OA\Property(property="punts_interes_id", type="integer", example=1),
 *             @OA\Property(property="visita_id", type="integer", example=2),
 *             @OA\Property(property="ordre", type="integer", example=3),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Punt d'interès associat a la visita correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés asociado a la visita correctamente"),
 *             @OA\Property(property="visita_punt_interes", ref="#/components/schemas/VisitesPuntsInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
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
 *     path="/visitespuntsinteres/{visitaId}/{puntInteresId}",
 *     summary="Obté informació d'una associació específica entre un punt d'interès i una visita",
 *     tags={"VisitesPuntsInteres"},
 *     @OA\Parameter(
 *         name="visitaId",
 *         in="path",
 *         required=true,
 *         description="ID de la visita",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="puntInteresId",
 *         in="path",
 *         required=true,
 *         description="ID del punt d'interès",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Informació de l'associació entre el punt d'interès i la visita",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="visita_punt_interes", ref="#/components/schemas/VisitesPuntsInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Associació no trobada")
 *         )
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
 *     path="/visitespuntsinteres/{visitaId}/{puntInteresId}",
 *     summary="Elimina una associació entre un punt d'interès i una visita",
 *     tags={"VisitesPuntsInteres"},
 *     @OA\Parameter(
 *         name="visitaId",
 *         in="path",
 *         required=true,
 *         description="ID de la visita",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="puntInteresId",
 *         in="path",
 *         required=true,
 *         description="ID del punt d'interès",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Punto de interés desasociado de la visita correctamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés desasociado de la visita correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No se encontró la asociación de punto de interés con la visita",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="No se encontró la asociación de punto de interés con la visita")
 *         )
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
