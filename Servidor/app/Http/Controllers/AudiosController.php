<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audios;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Tag(
 *     name="Audios",
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
     *                 @OA\Items(ref="#/components/schemas/Audios")
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Audios",
     *     type="object",
     *     @OA\Property(property="url", type="string", description="URL de l'audio"),
     *     @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès associat a l'audio")
     * )
     */

    public function index()
    {
        try {
            $tuples = Audios::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/api/audios",
     *   summary="Crea un nou audio",
     *   description="Guarda un nou audio a la base de dades",
     *   tags={"Audios"},
     *   @OA\RequestBody(
     *       required=true,
     *       description="Dades per al nou audio",
     *       @OA\JsonContent(
     *          required={"url", "punt_interes_id"},
     *          @OA\Property(property="url", type="string", example="http://exemple.com/audio.mp3"),
     *          @OA\Property(property="punt_interes_id", type="integer", example=1)
     *       ),
     *   ),
     *   @OA\Response(
     *       response=200,
     *       description="Audio creat amb èxit",
     *       @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="success"),
     *          @OA\Property(property="data", type="object", ref="#/components/schemas/Audios")
     *       )
     *   ),
     *   @OA\Response(
     *       response=400,
     *       description="Error de validació",
     *   ),
     *   @OA\Response(
     *       response=500,
     *       description="Error del servidor",
     *   ),
     * )
     *
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'audio' => 'required|mimes:mp3,wav,ogg|max:102400', // Cambio de mimes y max para audio
                'punt_interes_id' => 'required|exists:punts_interes,id',
                'espai_id' => 'required|exists:espais,id',
            ];
            $missatges = [
                'mimes' => 'Es requereix mp3, wav, ogg', // Cambio de mensaje
                'max' => 'Excedit el tamany màxim de 100 MB', // Cambio de mensaje
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
                'required' => 'El camp :attribute és obligatori.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            // Guardar el audio utilizando Eloquent
            $audioModelo = new Audios();
            $audioModelo->punt_interes_id = $request->punt_interes_id;
            $audioModelo->espai_id = $request->espai_id;

            if ($request->hasFile('audio')) {
                $audio = $request->file('audio');
                $nombreAudio = time() . '_' . $audio->getClientOriginalName();
                $ruta = $audio->storeAs('/audios', $nombreAudio);
                $audioModelo->audio = $ruta;
            }

            $audioModelo->save();

            return response()->json(['status' => 'success', 'data' => $audioModelo], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tupla = Audios::findOrFail($id);

            $reglesValidacio = [
                'punt_interes_id' => 'filled|exists:punts_interes,id',
                'espai_id' => 'filled|exists:espais,id',
            ];
            $missatges = [
                'mimes' => 'Es requereix jpg,jpeg,bmp,png',
                'max' => 'Excedit el tamany màxim de 10240',
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
                'required' => 'El camp :attribute és obligatori.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla->punt_interes_id = $request->punt_interes_id;
            $tupla->espai_id = $request->espai_id;

            $tupla->save();

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audios")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Audio no trobat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="No trobat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Audios::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Audios")
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Audios::findOrFail($id);
            $arxiuAudio = $tupla->audio;
            Storage::delete($arxiuAudio);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla, 'arxiu' => $arxiuAudio], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
