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
 *     path="/fotos",
 *     summary="Llista totes les fotos",
 *     tags={"Foto"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de totes les fotos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="fotos",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Foto")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Foto",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="url", type="string", example="http://exemple.com/foto.jpg"),
 *     @OA\Property(property="punt_interes_id", type="integer", example=1),
 *     @OA\Property(property="espai_id", type="integer", example=2),
 *     @OA\Property(property="comentari", type="string", example="Comentari sobre la foto"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *     
 * )
 */
    public function index()
    {
        $fotos = Foto::all();
        return response()->json(['fotos' => $fotos], 200);
    }

   /**
 * @OA\Post(
 *     path="/fotos",
 *     summary="Crea una nova foto",
 *     tags={"Foto"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades i fitxer necessaris per a crear una nova foto",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"imatge", "punt_interes_id", "espai_id"},
 *                 @OA\Property(
 *                     property="imatge",
 *                     description="Fitxer de la imatge",
 *                     type="string",
 *                     format="binary"
 *                 ),
 *                 @OA\Property(property="punt_interes_id", type="integer", example=1),
 *                 @OA\Property(property="espai_id", type="integer", example=2),
 *                 @OA\Property(property="comentari", type="string", example="Comentari sobre la foto"),
 *                 @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="foto", type="object", ref="#/components/schemas/Foto")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 *     
 * )
 */
    public function store(Request $request)
{
    $reglesValidacio = [
        'imatge' => 'required|file|image|max:2048', // Mida màxima de 2MB
        'punt_interes_id' => 'required|exists:punts_interes,id',
        'espai_id' => 'required|exists:espais,id',
        'comentari' => 'nullable|string',
        'data_baixa' => 'nullable|date',
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    if ($request->hasFile('imatge') && $request->file('imatge')->isValid()) {
        $path = $request->imatge->store('public/fotos');
        $url = \Storage::url($path);
        $request->merge(['url' => $url]);
    }

    $foto = Foto::create($request->all());
    return response()->json(['foto' => $foto], 200);
}


/**
 * @OA\Put(
 *     path="/fotos/{id}",
 *     summary="Actualitza una foto existent",
 *     tags={"Foto"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la foto a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la foto",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="imatge",
 *                     description="Fitxer de la imatge actualitzat",
 *                     type="string",
 *                     format="binary",
 *                     nullable=true
 *                 ),
 *                 @OA\Property(property="comentari", type="string", example="Nou comentari sobre la foto", nullable=true),
 *                 @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="foto", type="object", ref="#/components/schemas/Foto")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Foto no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Foto no trobada")
 *         )
 *     )
 * )
 */
public function update(Request $request, $id)
{
    $reglesValidacio = [
        'imatge' => 'nullable|file|image|max:2048', // Mida màxima de 2MB
        'comentari' => 'nullable|string',
        'data_baixa' => 'nullable|date',
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    $foto = Foto::findOrFail($id);

    if ($request->hasFile('imatge') && $request->file('imatge')->isValid()) {
        $path = $request->imatge->store('public/fotos');
        $url = \Storage::url($path);
        $request->merge(['url' => $url]);
    }

    $foto->update($request->all());
    return response()->json(['foto' => $foto], 200);
}

    
/**
 * @OA\Get(
 *     path="/fotos/{id}",
 *     summary="Obté una foto específica",
 *     tags={"Foto"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la foto a obtenir",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto trobada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Foto trobada amb èxit"),
 *             @OA\Property(property="foto", type="object", ref="#/components/schemas/Foto")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Foto no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Foto no trobada")
 *         )
 *     )
 * )
 */
public function show($id)
{
    try {
        $foto = Foto::findOrFail($id);
        return response()->json(['message' => 'Foto trobada amb èxit', 'foto' => $foto], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Foto no trobada'], 404);
    }
}





/**
 * @OA\Delete(
 *     path="/fotos/{id}",
 *     summary="Elimina una foto específica",
 *     tags={"Foto"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la foto a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Foto eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Foto no trobada",
 *         @OA\JsonContent(
 *             type="object",
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

