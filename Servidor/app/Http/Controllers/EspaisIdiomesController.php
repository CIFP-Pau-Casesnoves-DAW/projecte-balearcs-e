<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaiIdioma;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaisIdiomes",
 *     description="Operacions per a Traduccions d'Espais en Diferents Idiomes"
 * )
 */
class EspaisIdiomesController extends Controller
{
    /**
 * @OA\Get(
 *     path="/espais-idiomes",
 *     summary="Llista totes les traduccions dels espais",
 *     tags={"EspaisIdiomes"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de totes les traduccions dels espais",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/EspaisIdiomes")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="EspaisIdiomes",
 *     type="object",
 *     @OA\Property(property="idioma_id", type="integer", example=1),
 *     @OA\Property(property="espai_id", type="integer", example=2),
 *     @OA\Property(property="traduccio", type="string", example="Descripció traduïda de l'espai"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 * )
 */
    public function index()
    {
        $espaisIdiomes = EspaiIdioma::all();
        return response()->json(['espais_idiomes' => $espaisIdiomes], 200);
    }

    /**
 * @OA\Post(
 *     path="/espais-idiomes",
 *     summary="Crea una nova traducció per un espai",
 *     tags={"EspaisIdiomes"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"idioma_id", "espai_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=2),
 *             @OA\Property(property="traduccio", type="string", example="Descripció traduïda de l'espai"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="espais_idiomes", type="object", ref="#/components/schemas/EspaisIdiomes")
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
 */
    public function store(Request $request)
    {
        $reglesValidacio = [
            'idioma_id' => 'required|exists:idiomes,id',
            'espai_id' => 'required|exists:espais,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $espaiIdioma = EspaiIdioma::create($request->all());
        return response()->json(['espai_idioma' => $espaiIdioma], 200);
    }

    /**
 * @OA\Get(
 *     path="/espais-idiomes/{idioma_id}/{espai_id}",
 *     summary="Obté una traducció específica d'un espai",
 *     tags={"EspaisIdiomes"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="espai_idioma", type="object", ref="#/components/schemas/EspaisIdiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
 *         )
 *     )
 * )
 */
    public function show($idioma_id, $espai_id)
    {
        $espaiIdioma = EspaiIdioma::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
        if (!$espaiIdioma) {
            return response()->json(['message' => 'Traducció no trobada'], 404);
        }
        return response()->json(['espai_idioma' => $espaiIdioma], 200);
    }

    

/**
 * @OA\Put(
 *     path="/espais-idiomes/{idioma_id}/{espai_id}",
 *     summary="Actualitza una traducció d'un espai",
 *     tags={"EspaisIdiomes"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"traduccio"},
 *             @OA\Property(property="traduccio", type="string", example="Nova descripció traduïda de l'espai"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-02", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció actualitzada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="espai_idioma", type="object", ref="#/components/schemas/EspaisIdiomes")
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
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
 *         )
 *     )
 * )
 */
public function update(Request $request, $idioma_id, $espai_id)
{
    $reglesValidacio = [
        'traduccio' => 'required|string',
        'data_baixa' => 'nullable|date',
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    $espaiIdioma = EspaiIdioma::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
    if (!$espaiIdioma) {
        return response()->json(['message' => 'Traducció no trobada'], 404);
    }

    $espaiIdioma->update($request->all());
    return response()->json(['espai_idioma' => $espaiIdioma], 200);
}

/**
 * @OA\Delete(
 *     path="/espais-idiomes/{idioma_id}/{espai_id}",
 *     summary="Elimina una traducció d'un espai",
 *     tags={"EspaisIdiomes"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
 *         )
 *     )
 * )
 */
public function destroy($idioma_id, $espai_id)
{
    $espaiIdioma = EspaiIdioma::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
    if (!$espaiIdioma) {
        return response()->json(['message' => 'Traducció no trobada'], 404);
    }

    $espaiIdioma->delete();
    return response()->json(['message' => 'Traducció eliminada correctament'], 200);
}
}

