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
     *         description="Retorna un llistat de punts d'interès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PuntsInteres")
     *         )
     *     )
     * )
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
     *     path="/api/puntsinteres",
     *     tags={"PuntsInteres"},
     *     summary="Crea un nou punt d'interès",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès creat correctament"
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

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Mostra un punt d'interès específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna el punt d'interès especificat",
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = PuntsInteres::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Actualitza un punt d'interès específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès actualitzat correctament"
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Elimina un punt d'interès específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès eliminat correctament"
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
