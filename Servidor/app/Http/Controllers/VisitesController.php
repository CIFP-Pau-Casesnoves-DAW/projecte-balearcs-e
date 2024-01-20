<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visites;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Visites",
 *     description="Operacions per a Visites"
 * )
 */
class VisitesController extends Controller
{
    /**
     * Muestra una lista de todas las visitas.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/visites",
     *     tags={"Visites"},
     *     summary="Llista totes les visites",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les visites",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Visites")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Visites::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena una nueva visita en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/visites",
     *     tags={"Visites"},
     *     summary="Crea una nova visita",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visita creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'titol' => 'required|string|max:255',
                'descripcio' => 'required|string',
                'inscripcio_previa' => 'required|boolean',
                'n_places' => 'required|integer',
                'total_visitants' => 'nullable|integer',
                'data_inici' => 'required|date',
                'data_fi' => 'required|date',
                'horari' => 'required|string',
                'data_baixa' => 'nullable|date',
                'espai_id' => 'required|int',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Visites::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Visites::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la visita especificada.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Mostra una visita específica",
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
     *         description="Retorna la visita especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Visites::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza la visita especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Actualitza una visita específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visita actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Visites::findOrFail($id);
            $reglesValidacio = [
                'titol' => 'nullable|string|max:255',
                'descripcio' => 'nullable|string',
                'inscripcio_previa' => 'nullable|boolean',
                'n_places' => 'nullable|integer',
                'total_visitants' => 'nullable|integer',
                'data_inici' => 'nullable|date',
                'data_fi' => 'nullable|date',
                'horari' => 'nullable|string',
                'espai_id' => 'nullable|int',
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
     * Elimina la visita especificada de la base de datos.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Elimina una visita específica",
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
     *         description="Visita eliminada correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Visites::findOrFail($id);
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
            $visites = Visites::findOrFail($id);
            $visites->data_baixa = now();
            $visites->save();
            return response()->json(['status' => 'success', 'data' => $visites], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
