<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiIdioma",
 *     description="Operacions per a Traduccions d'Espais en Diferents Idiomes"
 * )
 */
class EspaisIdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais-idiomes",
     *     tags={"EspaiIdioma"},
     *     summary="Llista totes les traduccions d'espais",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les traduccions d'espais",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaiIdioma")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $espaisIdiomes = EspaisIdiomes::all();
        return response()->json(['espais_idiomes' => $espaisIdiomes], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/espais-idiomes",
     *     tags={"EspaiIdioma"},
     *     summary="Crea una nova traducció per un espai",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idioma_id", "espai_id", "traduccio"},
     *             @OA\Property(property="idioma_id", type="integer", example=1),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="traduccio", type="string", example="Descripció de l'espai en un idioma específic"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
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
            'idioma_id' => 'required|exists:idiomes,id',
            'espai_id' => 'required|exists:espais,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $espaiIdioma = EspaisIdiomes::create($request->all());
        return response()->json(['espai_idioma' => $espaiIdioma], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"EspaiIdioma"},
     *     summary="Mostra una traducció específica d'un espai",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="espai_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna la traducció específica",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
     *     )
     * )
     */
    public function show($idioma_id, $espai_id)
    {
        $espaiIdioma = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
        if (!$espaiIdioma) {
            return response()->json(['message' => 'Traducció no trobada'], 404);
        }
        return response()->json(['espai_idioma' => $espaiIdioma], 200);
    }



    /**
     * @OA\Put(
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"EspaiIdioma"},
     *     summary="Actualitza la traducció d'un espai específic",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="espai_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="traduccio", type="string", example="Nova descripció de l'espai en un idioma específic"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
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
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idioma_id, $espai_id)
    {
        $reglesValidacio = [
            'traduccio' => 'nullable|string',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $espaiIdioma = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
        if (!$espaiIdioma) {
            return response()->json(['message' => 'Traducció no trobada'], 404);
        }

        $espaiIdioma->update($request->all());
        return response()->json(['espai_idioma' => $espaiIdioma], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"EspaiIdioma"},
     *     summary="Elimina la traducció d'un espai específic",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="espai_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció eliminada correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
     *     )
     * )
     */
    public function destroy($idioma_id, $espai_id)
    {
        $espaiIdioma = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
        if (!$espaiIdioma) {
            return response()->json(['message' => 'Traducció no trobada'], 404);
        }

        $espaiIdioma->delete();
        return response()->json(['message' => 'Traducció eliminada correctament'], 200);
    }
}
