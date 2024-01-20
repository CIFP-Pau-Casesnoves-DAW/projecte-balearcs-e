<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesPuntsInteres;
use Illuminate\Support\Facades\Validator;

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
     * @param  int  $visita_id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/visites/{visita_id}/puntsinteres",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Llista tots els punts d'interès d'una visita",
     *     @OA\Parameter(
     *         name="visita_id",
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
    public function index()
    {
        try {
            $tuples = VisitesPuntsInteres::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
        try {
            $reglesValidacio = [
                'punts_interes_id' => 'required|exists:punts_interes,id',
                'visita_id' => 'required|exists:visites,id',
                'ordre' => 'required|integer',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = VisitesPuntsInteres::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la asociación de punto de interés específica.
     *
     * @param  int  $visita_id
     * @param  int  $punts_interes_id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/visites/{visita_id}/puntsinteres/{punts_interes_id}",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Mostra una associació específica entre una visita i un punt d'interès",
     *     @OA\Parameter(
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="punts_interes_id",
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
    public function show($visita_id, $punts_interes_id)
    {
        try {
            $visitapuntinteres = VisitesPuntsInteres::where('visita_id', $visita_id)->where('punts_interes_id', $punts_interes_id)->first();
            if (!$visitapuntinteres) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }
            return response()->json(['punts_interes_idioma' => $visitapuntinteres], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $visita_id, $punts_interes_id)
    {
        try {
            $reglesValidacio = [
                'punts_interes_id' => 'nullable|exists:punts_interes,id',
                'visita_id' => 'nullable|exists:visites,id',
                'ordre' => 'nullable|integer',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                return response()->json(['errors' => $validacio->errors()], 400);
            }

            $visitapuntinteres = VisitesPuntsInteres::where('visita_id', $visita_id)->where('punts_interes_id', $punts_interes_id)->first();
            if (!$visitapuntinteres) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }

            $visitapuntinteres->update($request->all());
            return response()->json(['punts_interes_idioma' => $visitapuntinteres], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Desasocia un punto de interés de una visita.
     *
     * @param  int  $visita_id
     * @param  int  $punts_interes_id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/visites/{visita_id}/puntsinteres/{punts_interes_id}",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Elimina una associació específica entre una visita i un punt d'interès",
     *     @OA\Parameter(
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="punts_interes_id",
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
    public function destroy($visita_id, $punts_interes_id)
    {
        try {
            $visitapuntinteres = VisitesPuntsInteres::where('visita_id', $visita_id)->where('punts_interes_id', $punts_interes_id)->first();
            if (!$visitapuntinteres) {
                return response()->json(['message' => 'No trobat'], 404);
            }

            $visitapuntinteres->delete();
            return response()->json(['message' => 'Eliminat correctament'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
