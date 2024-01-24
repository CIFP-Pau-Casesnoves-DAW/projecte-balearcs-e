<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fotos;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Foto",
 *     description="Operacions per a Fotos d'Espais i Punts d'Interès"
 * )
 */
class FotosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/fotos",
     *     tags={"Foto"},
     *     summary="Llista totes les fotos",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les fotos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Foto")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Fotos::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/fotos",
     *     tags={"Foto"},
     *     summary="Crea una nova foto",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url", "punt_interes_id", "espai_id"},
     *             @OA\Property(property="url", type="string", example="https://exemple.com/foto.jpg"),
     *             @OA\Property(property="punt_interes_id", type="integer", example=1),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="comentari", type="string", example="Comentari sobre la foto", nullable=true),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Foto creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Foto")
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
                'url' => 'required|string',
                'punt_interes_id' => 'required|exists:punts_interes,id',
                'espai_id' => 'required|exists:espais,id',
                'comentari' => 'nullable|string',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Fotos::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    // Continuació de FotosController

    /**
     * @OA\Get(
     *     path="/api/fotos/{id}",
     *     tags={"Foto"},
     *     summary="Mostra una foto específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna la foto específica",
     *         @OA\JsonContent(ref="#/components/schemas/Foto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Foto no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foto no trobada")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/fotos/{id}",
     *     tags={"Foto"},
     *     summary="Actualitza una foto específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="url", type="string", example="https://exemple.com/foto_actualitzada.jpg"),
     *             @OA\Property(property="comentari", type="string", example="Nou comentari sobre la foto", nullable=true),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Foto actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Foto")
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
     *         description="Foto no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foto no trobada")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
            $reglesValidacio = [
                'url' => 'nullable|string',
                'comentari' => 'nullable|string',
                'punt_interes_id' => 'nullable|exists:punts_interes,id',
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
     * @OA\Delete(
     *     path="/api/fotos/{id}",
     *     tags={"Foto"},
     *     summary="Elimina una foto específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Foto eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foto eliminada correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Foto no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foto no trobada")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
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
            $foto = Fotos::findOrFail($id);
            $foto->data_baixa = now();
            $foto->save();
            return response()->json(['status' => 'success', 'data' => $foto], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
