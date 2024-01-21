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
 *     path="/api/visitespuntsinteres",
 *     tags={"VisitesPuntsInteres"},
 *     summary="Llista totes les associacions entre visites i punts d'interès",
 *     @OA\Response(
 *         response=200,
 *         description="Llista d'associacions entre visites i punts d'interès recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/VisitaPuntInteres")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="VisitaPuntInteres",
 *     type="object",
 *     @OA\Property(property="visita_id", type="integer", description="Identificador de la visita"),
 *     @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès"),
 *     @OA\Property(property="ordre", type="integer", description="Ordre del punt d'interès en la visita")
 *     
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
 *         description="Dades necessàries per a crear una nova associació entre una visita i un punt d'interès",
 *         @OA\JsonContent(
 *             required={"punts_interes_id", "visita_id", "ordre"},
 *             @OA\Property(property="punts_interes_id", type="integer", description="Identificador del punt d'interès"),
 *             @OA\Property(property="visita_id", type="integer", description="Identificador de la visita"),
 *             @OA\Property(property="ordre", type="integer", description="Ordre del punt d'interès dins la visita")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nova associació creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/VisitaPuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
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
 *     path="/api/visitespuntsinteres/{visita_id}/{punts_interes_id}",
 *     tags={"VisitesPuntsInteres"},
 *     summary="Obté una associació específica entre una visita i un punt d'interès",
 *     @OA\Parameter(
 *         name="visita_id",
 *         in="path",
 *         required=true,
 *         description="Identificador de la visita",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="punts_interes_id",
 *         in="path",
 *         required=true,
 *         description="Identificador del punt d'interès",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació entre la visita i el punt d'interès trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="punts_interes_idioma", type="object", ref="#/components/schemas/VisitaPuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
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

    /**
 * @OA\Put(
 *     path="/api/visitespuntsinteres/{visita_id}/{punts_interes_id}",
 *     tags={"VisitesPuntsInteres"},
 *     summary="Actualitza una associació existent entre una visita i un punt d'interès",
 *     @OA\Parameter(
 *         name="visita_id",
 *         in="path",
 *         required=true,
 *         description="Identificador de la visita",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="punts_interes_id",
 *         in="path",
 *         required=true,
 *         description="Identificador del punt d'interès",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la associació entre la visita i el punt d'interès",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="punts_interes_id", type="integer", description="Identificador actualitzat del punt d'interès"),
 *             @OA\Property(property="visita_id", type="integer", description="Identificador actualitzat de la visita"),
 *             @OA\Property(property="ordre", type="integer", description="Ordre actualitzat del punt d'interès dins la visita")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="punts_interes_idioma", type="object", ref="#/components/schemas/VisitaPuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

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
 *     path="/api/visitespuntsinteres/{visita_id}/{punts_interes_id}",
 *     tags={"VisitesPuntsInteres"},
 *     summary="Elimina una associació existent entre una visita i un punt d'interès",
 *     @OA\Parameter(
 *         name="visita_id",
 *         in="path",
 *         required=true,
 *         description="Identificador de la visita",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="punts_interes_id",
 *         in="path",
 *         required=true,
 *         description="Identificador del punt d'interès",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Eliminat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="No trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
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