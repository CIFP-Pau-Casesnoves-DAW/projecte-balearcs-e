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
class AudioController extends Controller
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
        $audios = Audio::all();
        return response()->json(['status' => 'correcte', 'data' => $audios], 200);
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
    // Regles de validació
    $reglesValidacio = [
        'url' => 'required|url',
        'punt_interes_id' => 'required|exists:punts_interes,id',
        'data_baixa' => 'nullable|date',
    ];

    // Realitza la validació
    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['error' => $validacio->errors()], 400);
    }

    // Crea un nou audio
    $audio = Audio::create($request->all());
    return response()->json($audio, 200);
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
        $audio = Audio::findOrFail($id);
        return response()->json(['status' => 'correcte', 'data' => $audio], 200);
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
    // Regles de validació
    $reglesValidacio = [
        'url' => 'required|url',
        'punt_interes_id' => 'required|exists:punts_interes,id',
        'data_baixa' => 'nullable|date',
    ];

    // Realitza la validació
    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['error' => $validacio->errors()], 400);
    }

    // Troba i actualitza l'audio
    $audio = Audio::findOrFail($id);
    $audio->update($request->all());
    return response()->json($audio, 200);
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
        $audio = Audio::findOrFail($id);
        $audio->delete();
        return response()->json(['status' => 'success', 'message' => 'Audio eliminat correctament'], 200);
    }
}


