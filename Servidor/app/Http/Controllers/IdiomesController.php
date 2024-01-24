<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Idioma",
 *     description="Operacions per a Idiomes"
 * )
 */
class IdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/idiomes",
     *     tags={"Idioma"},
     *     summary="Llista tots els idiomes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els idiomes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Idioma")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Idiomes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/idiomes",
     *     tags={"Idioma"},
     *     summary="Crea un nou idioma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Català")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Idioma creat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Idioma")
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
                'idioma' => 'required|string|max:255',
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

            $tupla = Idiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/idiomes/{id}",
     *     tags={"Idioma"},
     *     summary="Mostra un idioma específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna l'idioma específic",
     *         @OA\JsonContent(ref="#/components/schemas/Idioma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Idioma no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Idioma no trobat")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Idiomes::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/idiomes/{id}",
     *     tags={"Idioma"},
     *     summary="Actualitza un idioma específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom"},
     *             @OA\Property(property="nom", type="string", example="Anglès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Idioma actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Idioma")
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
     *         description="Idioma no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Idioma no trobat")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Idiomes::findOrFail($id);
            $reglesValidacio = [
                'idioma' => 'nullable|string|max:255',
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
     *     path="/api/idiomes/{id}",
     *     tags={"Idioma"},
     *     summary="Elimina un idioma específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Idioma eliminat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Idioma eliminat correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Idioma no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Idioma no trobat")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Idiomes::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
