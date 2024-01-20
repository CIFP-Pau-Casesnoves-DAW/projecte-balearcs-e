<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipus;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Tipus",
 *     description="Operacions per a Tipus"
 * )
 */
class TipusController extends Controller
{
    /**
     * Muestra una lista de todos los tipos.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/tipus",
     *     tags={"Tipus"},
     *     summary="Llista tots els tipus",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els tipus",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tipus")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Tipus::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena un nuevo tipo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/tipus",
     *     tags={"Tipus"},
     *     summary="Crea un nou tipus",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom_tipus' => 'required|string|max:255',
                'data_baixa' => 'nullable|date',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Tipus::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra el tipo especificado.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Mostra un tipus específic",
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
     *         description="Retorna el tipus especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza el tipo especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Actualitza un tipus específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            $reglesValidacio = [
                'nom_tipus' => 'nullable|string|max:255',
                'data_baixa' => 'nullable|date',
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
     * Elimina el tipo especificado de la base de datos.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Elimina un tipus específic",
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
     *         description="Tipus eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
