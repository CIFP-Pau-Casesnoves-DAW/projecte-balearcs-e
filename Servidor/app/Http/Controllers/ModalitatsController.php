<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalitats;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Modalitat",
 *     description="Operacions per a Modalitats"
 * )
 */
class ModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/modalitats",
     *     tags={"Modalitat"},
     *     summary="Llista totes les modalitats",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les modalitats",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Modalitat")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Modalitats::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/modalitats",
     *     tags={"Modalitat"},
     *     summary="Crea una nova modalitat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom_modalitat"},
     *             @OA\Property(property="nom_modalitat", type="string", example="Pintura")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom_modalitat' => 'required|string|max:255',
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

            $tupla = Modalitats::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    // Continuació de ModalitatsController

    /**
     * @OA\Get(
     *     path="/api/modalitats/{id}",
     *     tags={"Modalitat"},
     *     summary="Mostra una modalitat específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna la modalitat específica",
     *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalitat no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Modalitats::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/modalitats/{id}",
     *     tags={"Modalitat"},
     *     summary="Actualitza una modalitat específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom_modalitat"},
     *             @OA\Property(property="nom_modalitat", type="string", example="Escultura")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalitat no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Modalitats::findOrFail($id);
            $reglesValidacio = [
                'nom_modalitat' => 'nullable|string|max:255',
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
     * @OA\Delete(
     *     path="/api/modalitats/{id}",
     *     tags={"Modalitat"},
     *     summary="Elimina una modalitat específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modalitat eliminada correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalitat no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Modalitats::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
