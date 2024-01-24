<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracions;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Valoracions",
 *     description="Operacions per a Valoracions"
 * )
 */
class ValoracionsController extends Controller
{
    /**
     * Muestra una lista de todas las valoraciones.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/valoracions",
     *     tags={"Valoracions"},
     *     summary="Llista totes les valoracions",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de valoracions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Valoracions")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Valoracions::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Comentari no trobat'], 400);
        }
    }

    /**
     * Almacena una nueva valoración en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/valoracions",
     *     tags={"Valoracions"},
     *     summary="Crea una nova valoració",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $mdId = $request->md_id;

            $request->merge(['data' => Carbon::now()]);
            $request->merge(['usuari_id' => $mdId]);

            $reglesValidacio = [
                'puntuacio' => 'required|integer',
                'espai_id' => 'required|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Valoracions::create($request->all());

            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la valoración especificada.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Mostra una valoració específica",
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
     *         description="Retorna la valoració especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Valoracions::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        }
    }

    /**
     * Actualiza la valoración especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Actualitza una valoració específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Valoracions::findOrFail($id);

            $reglesValidacio = [
                'puntuacio' => 'nullable|integer',
                'espai_id' => 'nullable|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('validat') && $mdRol == 'administrador') {
                $valoracio = Valoracions::find($id);
                $valoracio->validat = $request->input('validat');
                $valoracio->save();
            }

            if ($request->filled('usuari_id') && $mdRol == 'administrador') {
                $valoracio = Valoracions::find($id);
                $valoracio->usuari_id = $request->input('usuari_id');
                $valoracio->save();
            }

            if (empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = NULL;
                $tupla->save();
            } else if (!empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = now();
                $tupla->save();
            }

            $request->merge(['data' => Carbon::now()]);
            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Elimina la valoración especificada de la base de datos.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Elimina una valoració específica",
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
     *         description="Valoració eliminada correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $valoracio = Valoracions::findOrFail($id);
            $valoracio->delete();
            return response()->json(['status' => 'success', 'data' => $valoracio], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
