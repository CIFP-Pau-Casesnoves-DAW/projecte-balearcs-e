<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquitectes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Arquitecte",
 *     description="Operacions per a Arquitectes"
 * )
 */
class ArquitectesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/arquitectes",
     *     tags={"Arquitecte"},
     *     summary="Llista tots els arquitectes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els arquitectes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Arquitecte")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Arquitectes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/arquitectes",
     *     tags={"Arquitecte"},
     *     summary="Crea un nou arquitecte",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Arquitecte")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Arquitecte creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
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

            $tupla = Arquitectes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    // Mètodes show, update, i destroy amb la lògica corresponent per a arquitectes
    /**
     * @OA\Get(
     *     path="/api/arquitectes/{id}",
     *     tags={"Arquitecte"},
     *     summary="Mostra un arquitecte específic",
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
     *         description="Retorna l'arquitecte especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Arquitecte")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Arquitectes::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/arquitectes/{id}",
     *     tags={"Arquitecte"},
     *     summary="Actualitza un arquitecte específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'arquitecte a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades per a actualitzar un arquitecte",
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Joan"),
     *             // Afegiu altres propietats aquí segons el model Arquitecte
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Arquitecte actualitzat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Arquitecte no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Arquitecte no trobat")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Arquitectes::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
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
     * @OA\Delete(
     *     path="/api/arquitectes/{id}",
     *     tags={"Arquitecte"},
     *     summary="Elimina un arquitecte específic",
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
     *         description="Arquitecte eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Arquitectes::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
