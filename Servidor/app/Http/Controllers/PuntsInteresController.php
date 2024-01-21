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
 *     path="/api/punts-interes",
 *     tags={"Punts d'Interès"},
 *     summary="Llista tots els punts d'interès",
 *     @OA\Response(
 *         response=200,
 *         description="Llista de punts d'interès recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/PuntInteres")
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
 * 
 *   @OA\Schema(
 *     schema="PuntInteres",
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
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     path="/api/punts-interes",
 *     tags={"Punts d'Interès"},
 *     summary="Crea un nou punt d'interès",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades del punt d'interès a crear",
 *         @OA\JsonContent(
 *             @OA\Property(property="titol", type="string", description="Títol del punt d'interès"),
 *             @OA\Property(property="descripcio", type="string", description="Descripció del punt d'interès"),
 *             @OA\Property(property="espai_id", type="integer", description="ID de l'espai associat al punt d'interès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Punt d'interès creat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/PuntInteres")
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
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = PuntsInteres::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = PuntsInteres::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     path="/api/punts-interes/{id}",
 *     tags={"Punts d'Interès"},
 *     summary="Obté les dades d'un punt d'interès específic",
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
 *         description="Dades del punt d'interès trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/PuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Punt d'interès no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Punt d'interès no trobat")
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
    public function show($id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     path="/api/punts-interes/{id}",
 *     tags={"Punts d'Interès"},
 *     summary="Actualitza les dades d'un punt d'interès",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del punt d'interès",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades a actualitzar del punt d'interès",
 *         @OA\JsonContent(
 *             @OA\Property(property="titol", type="string", description="Títol del punt d'interès"),
 *             @OA\Property(property="descripcio", type="string", description="Descripció del punt d'interès"),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades del punt d'interès actualitzades amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/PuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació o punt d'interès no trobat",
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
 */
    public function update(Request $request, $id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            $reglesValidacio = [
                'titol' => 'nullable|string|max:255',
                'descripcio' => 'nullable|string|max:2000',
                'espai_id' => 'nullable|exists:espais,id',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     path="/api/punts-interes/{id}",
 *     tags={"Punts d'Interès"},
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
 *             @OA\Property(property="status", type="string", example="correcto"),
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
 *             @OA\Property(property="message", type="string")
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
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/punts-interes/{id}/delete",
 *     tags={"Punts d'Interès"},
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
 *             @OA\Property(property="status", type="string", example="correcto"),
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
 *             @OA\Property(property="message", type="string")
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
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}