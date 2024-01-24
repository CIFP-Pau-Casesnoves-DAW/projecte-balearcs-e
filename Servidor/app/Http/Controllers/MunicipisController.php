<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Municipis",
 *     description="Operacions per a Municipis"
 * )
 */

class MunicipisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/municipis",
     *     tags={"Municipis"},
     *     summary="Llista tots els municipis",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els municipis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Municipis")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Municipis::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/municipis",
     *     tags={"Municipis"},
     *     summary="Crea un nou municipi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Municipi creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'illa_id' => 'required|int',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.',
                'int' => 'El :attribute ha de ser un número vàlid',
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

            $tupla = Municipis::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Mostra un municipi específic",
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
     *         description="Retorna el municipi especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Municipis::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Actualitza un municipi específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Municipi actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Municipis::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'illa_id' => 'nullable|int',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.',
                'int' => 'El :attribute ha de ser un número vàlid',
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
     * @OA\Delete(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Elimina un municipi específic",
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
     *         description="Municipi eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Municipis::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
