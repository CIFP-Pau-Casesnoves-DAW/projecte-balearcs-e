<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audios;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Audio",
 *     description="Operacions per a Audios"
 * )
 */
class AudiosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/audios",
     *     tags={"Audio"},
     *     summary="Llista tots els audios",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els audios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Audio")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Audios::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/audios",
     *     tags={"Audio"},
     *     summary="Crea un nou audio",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear un nou audio",
     *         @OA\JsonContent(
     *             required={"url", "punt_interes_id"},
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com/audio.mp3"),
     *             @OA\Property(property="punt_interes_id", type="integer", example=1),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Audio creat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Audio")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Dades d'entrada no vàlides")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'url' => 'required|url',
                'punt_interes_id' => 'required|exists:punts_interes,id',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Audios::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Audios::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/audios/{id}",
     *     tags={"Audio"},
     *     summary="Mostra un audio específic",
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
     *         description="Retorna l'audio especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Audio")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Audios::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/audios/{id}",
     *     tags={"Audio"},
     *     summary="Actualitza un audio específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'audio a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades per a actualitzar un audio",
     *         @OA\JsonContent(
     *             @OA\Property(property="url", type="string", format="url", example="https://example.com/audio_updated.mp3"),
     *             @OA\Property(property="punt_interes_id", type="integer", example=2),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-02-01"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Audio actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Audio")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Dades d'entrada no vàlides")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Audio no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Audio no trobat")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Audios::findOrFail($id);
            $reglesValidacio = [
                'url' => 'nullable|url',
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
     *     path="/api/audios/{id}",
     *     tags={"Audio"},
     *     summary="Elimina un audio específic",
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
     *         description="Audio eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Audios::findOrFail($id);
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
            $audio = Audios::findOrFail($id);
            $audio->data_baixa = now();
            $audio->save();
            return response()->json(['status' => 'success', 'data' => $audio], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
