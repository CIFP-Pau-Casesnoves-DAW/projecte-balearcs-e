<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
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
        $fotos = Foto::all();
        return response()->json(['fotos' => $fotos], 200);
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
        $reglesValidacio = [
            'url' => 'required|url',
            'punt_interes_id' => 'required|exists:punts_interes,id',
            'espai_id' => 'required|exists:espais,id',
            'comentari' => 'nullable|string',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $foto = Foto::create($request->all());
        return response()->json(['foto' => $foto], 200);
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
    $foto = Foto::find($id);
    if (!$foto) {
        return response()->json(['message' => 'Foto no trobada'], 404);
    }
    return response()->json(['foto' => $foto], 200);
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
    $reglesValidacio = [
        'url' => 'required|url',
        'comentari' => 'nullable|string',
        'data_baixa' => 'nullable|date',
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    $foto = Foto::find($id);
    if (!$foto) {
        return response()->json(['message' => 'Foto no trobada'], 404);
    }

    $foto->update($request->all());
    return response()->json(['foto' => $foto], 200);
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
    $foto = Foto::find($id);
    if (!$foto) {
        return response()->json(['message' => 'Foto no trobada'], 404);
    }

    $foto->delete();
    return response()->json(['message' => 'Foto eliminada correctament'], 200);
}

}

