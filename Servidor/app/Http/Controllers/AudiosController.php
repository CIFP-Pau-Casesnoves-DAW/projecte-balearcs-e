<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audio;
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
 *     tags={"Audios"},
 *     summary="Llista tots els audios",
 *     @OA\Response(
 *         response=200,
 *         description="Retorna un llistat de tots els audios",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Audio")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Audio",
 *     type="object",
 *     @OA\Property(property="url", type="string", description="URL de l'audio"),
 *     @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès associat a l'audio")
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
 *     tags={"Audios"},
 *     summary="Crea un nou audio",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou audio",
 *         @OA\JsonContent(
 *             required={"url", "punt_interes_id"},
 *             @OA\Property(property="url", type="string", format="uri", description="URL de l'audio"),
 *             @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès associat a l'audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nou audio creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
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
 *     tags={"Audios"},
 *     summary="Obté les dades d'un audio específic",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'audio",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'audio trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Audio no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Usuari no trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
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
 *     tags={"Audios"},
 *     summary="Actualitza un audio existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'audio a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'audio a actualitzar",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="url", type="string", format="uri", description="URL de l'audio"),
 *             @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès associat a l'audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'audio actualitzades correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
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
 *     tags={"Audios"},
 *     summary="Elimina un audio existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'audio a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Audio eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Audio no trobat o error en l'eliminació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
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


