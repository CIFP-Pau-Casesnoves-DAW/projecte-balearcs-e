<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idioma;
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
        $idiomes = Idioma::all();
        return response()->json(['idiomes' => $idiomes], 200);
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
        $reglesValidacio = [
            'nom' => 'required|string|max:255'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $idioma = Idioma::create($request->all());
        return response()->json(['idioma' => $idioma], 200);
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
    $idioma = Idioma::find($id);
    if (!$idioma) {
        return response()->json(['message' => 'Idioma no trobat'], 404);
    }
    return response()->json(['idioma' => $idioma], 200);
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
    $reglesValidacio = [
        'nom' => 'required|string|max:255'
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    $idioma = Idioma::find($id);
    if (!$idioma) {
        return response()->json(['message' => 'Idioma no trobat'], 404);
    }

    $idioma->update($request->all());
    return response()->json(['idioma' => $idioma], 200);
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
    $idioma = Idioma::find($id);
    if (!$idioma) {
        return response()->json(['message' => 'Idioma no trobat'], 404);
    }

    $idioma->delete();
    return response()->json(['message' => 'Idioma eliminat correctament'], 200);
}

}
