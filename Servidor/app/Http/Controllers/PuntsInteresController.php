<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntsInteres;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="PuntsInteres",
 *     description="Operacions per a Punts d'Interès"
 * )
 */
class PuntsInteresController extends Controller
{
    /**
     * Muestra una lista de todos los puntos de interés.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/puntsinteres",
     *     tags={"PuntsInteres"},
     *     summary="Llista tots els punts d'interès",
     *     @OA\Response(
     *         response=200,
     *         description="Llista de punts d'interès recuperada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PuntsInteres")
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
     *   @OA\Schema(
     *     schema="PuntsInteres",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="Identificador únic del punt d'interès"),
     *     @OA\Property(property="nom", type="string", description="Nom del punt d'interès"),
     *     @OA\Property(property="descripcio", type="string", description="Descripció del punt d'interès"),
     *     @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat"),
     *     @OA\Property(property="data_creacio", type="string", format="date-time", description="Data de creació del punt d'interès"),
     *     @OA\Property(property="data_baixa", type="string", format="date-time", description="Data de baixa del punt d'interès")
     * )
     * 
     */
    public function index()
    {
        try {
            $tuples = PuntsInteres::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena un nuevo punto de interés en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/puntsinteres",
     *     summary="Crea un nou punt d'interès",
     *     tags={"PuntsInteres"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Introdueix dades per crear un nou punt d'interès",
     *         @OA\JsonContent(
     *             required={"titol", "descripcio", "espai_id"},
     *             @OA\Property(property="titol", type="string", example="Títol del punt d'interès"),
     *             @OA\Property(property="descripcio", type="string", example="Descripció del punt d'interès"),
     *             @OA\Property(property="espai_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès creat amb èxit",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dades invàlides o error en la petició",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Missatge d'error")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'titol' => 'required|string|max:255',
                'descripcio' => 'required|string|max:2000',
                'espai_id' => 'required|exists:espais,id',
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

            $tupla = PuntsInteres::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra el punto de interés especificado.
     *
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Obté les dades d'un punt d'interès específic",
     *     description="Retorna les dades d'un punt d'interès donat el seu identificador únic.",
     *     operationId="showPuntsInteres",
     *     @OA\Parameter(
     *         name="id",
     *         description="Identificador únic del punt d'interès",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades del punt d'interès trobades amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/PuntsInteres")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Punt d'interès no trobat",
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
     *     
     * )
     * 
     */

    public function show($id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza el punto de interés especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/puntsinteres/{id}",
     *     operationId="updatePuntsInteres",
     *     tags={"PuntsInteres"},
     *     summary="Actualitza un punt d'interès",
     *     description="Actualitza la informació d'un punt d'interès existent.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del punt d'interès a actualitzar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades del punt d'interès per actualitzar",
     *         @OA\JsonContent(
     *             required={"titol", "descripcio"},
     *             @OA\Property(property="titol", type="string", example="Títol actualitzat"),
     *             @OA\Property(property="descripcio", type="string", example="Descripció actualitzada"),
     *             @OA\Property(property="espai_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès actualitzat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/PuntsInteres")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dades invàlides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Punt d'interès no trobat"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     *  
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            $reglesValidacio = [
                'titol' => 'filled|string|max:255',
                'descripcio' => 'nullable|string|max:2000',
                'espai_id' => 'filled|exists:espais,id',
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
            $mdRol = $request->md_rol;
            if (empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = NULL;
                $tupla->save();
            }

            if (!empty($request->espai_id) && $mdRol == 'administrador') {
                $request->merge(['espai_id' => $request->espai_id]);
            }

            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Elimina el punto de interés especificado de la base de datos.
     *
     * @param  \App\Models\PuntsInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Elimina un punt d'interès",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic del punt d'interès",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès eliminat amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Punt d'interès no trobat o error en la sol·licitud",
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
     */
    public function destroy($id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/puntsinteres/{id}/delete",
     *     tags={"PuntsInteres"},
     *     summary="Realitza una eliminació lògica d'un punt d'interès",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic del punt d'interès",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eliminació lògica del punt d'interès realitzada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Punt d'interès no trobat o error en la sol·licitud",
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
     */
    public function delete($id)
    {
        try {
            $puntinteres = PuntsInteres::findOrFail($id);
            $puntinteres->data_baixa = now();
            $puntinteres->save();
            return response()->json(['status' => 'success', 'data' => $puntinteres], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
