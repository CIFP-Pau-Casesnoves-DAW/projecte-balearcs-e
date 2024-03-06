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
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/VisitesPuntsInteres")
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     *
     *
     *
     * @OA\Schema(
     *     schema="VisitesPuntsInteres",
     *     type="object",
     *     @OA\Property(property="visita_id", type="integer", description="Identificador de la visita"),
     *     @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès"),
     *     @OA\Property(property="ordre", type="integer", description="Ordre del punt d'interès en la visita")
     * )
     */


    public function index()
    {
        try {
            $tuples = VisitesPuntsInteres::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *     path="/visitesPuntsInteres",
     *     summary="Crea una nova relació entre una visita i un punt d'interès",
     *     tags={"VisitesPuntsInteres"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear una nova relació entre una visita i un punt d'interès",
     *         @OA\JsonContent(
     *             required={"punt_interes_id", "visita_id", "ordre"},
     *             @OA\Property(property="punt_interes_id", type="integer", example=1),
     *             @OA\Property(property="visita_id", type="integer", example=2),
     *             @OA\Property(property="ordre", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Relació creada correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/VisitesPuntsInteres")
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */


    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'punt_interes_id' => 'required|int|exists:punts_interes,id',
                'visita_id' => 'required|int|exists:visites,id',
                'ordre' => 'required|int',
            ];
            $missatges = [
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
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
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="punts_interes_idioma", type="object", ref="#/components/schemas/VisitesPuntsInteres")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Associació no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="string", example="Traducció no trobada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */

    public function show($visita_id, $punt_interes_id)
    {
        try {
            $visitapuntinteres = VisitesPuntsInteres::where('visita_id', $visita_id)->where('punt_interes_id', $punt_interes_id)->first();
            if (!$visitapuntinteres) {
                return response()->json(['status' => 'error', 'data' => 'No trobat'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $visitapuntinteres], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/visitespuntsinteres/{visita_id}/{punt_interes_id}",
     *     tags={"VisitesPuntsInteres"},
     *     summary="Actualitza una associació entre una visita i un punt d'interès",
     *     description="Actualitza les dades d'una associació específica entre una visita i un punt d'interès, com l'ordre de la visita en aquest punt.",
     *     @OA\Parameter(
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         description="Identificador de la visita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="punt_interes_id",
     *         in="path",
     *         required=true,
     *         description="Identificador del punt d'interès",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Dades opcionals per actualitzar la associació entre la visita i el punt d'interès",
     *         @OA\JsonContent(
     *             @OA\Property(property="punt_interes_id", type="integer", description="Identificador actualitzat del punt d'interès"),
     *             @OA\Property(property="visita_id", type="integer", description="Identificador actualitzat de la visita"),
     *             @OA\Property(property="ordre", type="integer", description="Ordre actualitzat del punt d'interès en la visita")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació actualitzada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/VisitesPuntsInteres")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validació de dades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No s'ha trobat la associació especificada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */

    public function update(Request $request, $visita_id, $punt_interes_id)
    {
        $reglesValidacio = [
            'punt_interes_id' => 'filled|int|exists:punts_interes,id',
            'visita_id' => 'filled|int|exists:visites,id',
            'ordre' => 'filled|int',
        ];
        $missatges = [
            'filled' => 'El camp :attribute no pot estar buit',
            'exists' => ':attribute ha de existir',
            'required' => 'El camp :attribute és obligatori.',
            'max' => 'El :attribute ha de tenir màxim :max caràcters.'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        } else {
            try {
                $visita_punt_interes = VisitesPuntsInteres::where('punt_interes_id', $punt_interes_id)->where('visita_id', $visita_id);

                $visita_punt_interes->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $visita_punt_interes
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error', 'data' => 'La traduccio de la visita amb la id ' . $visita_id . 'amb punt interes ' . $punt_interes_id . 'no existeix'
                ], 404);
            }
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
     *     summary="Esborra l'associació entre un punt d'interès i una visita específica",
     *     description="Elimina l'associació entre un punt d'interès i una visita, identificats pels seus respectius IDs.",
     *     @OA\Parameter(
     *         name="visita_id",
     *         description="Identificador únic de la visita",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="punt_interes_id",
     *         description="Identificador únic del punt d'interès",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació esborrada correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Esborrat correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Associació no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="No trobat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     ),
     *     security={{"apiAuth":{}}}
     * )
     */
    public function destroy($visita_id, $punt_interes_id)
    {
        try {
            $punt_interes_visita = VisitesPuntsInteres::where('punt_interes_id', $punt_interes_id)->where('visita_id', $visita_id);
            $punt_interes_visita->delete();

            if ($punt_interes_visita) {
                return response()->json(['status' => 'success', 'data' => 'Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'error', 'data' => 'No trobat'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
