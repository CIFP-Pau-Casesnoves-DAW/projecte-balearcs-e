<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Illes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Illes",
 *     description="Operacions relacionades amb les Illes"
 * )
 */
class IllesController extends Controller
{
    /**
     * Muestra una lista de todas las islas.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Llista totes les illes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les illes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Illes")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Illes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena una nueva isla en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Crea una nova illa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Illes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illes creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'zona' => 'required|string|max:255',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
            }

            $tupla = Illes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la isla especificada.
     *
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Mostra una illa específica",
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
     *         description="Retorna la illa especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Illes")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza la isla especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Actualitza una illa específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Illes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illes actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'zona' => 'nullable|string|max:255',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
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
     * Elimina la isla especificada de la base de datos.
     *
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Elimina una illa específica",
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
     *         description="Illes eliminada correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
