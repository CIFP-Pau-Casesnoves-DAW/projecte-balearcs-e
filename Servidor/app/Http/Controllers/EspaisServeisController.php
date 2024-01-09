<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisServeis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiServei",
 *     description="Operacions per a Serveis d'Espais"
 * )
 */
class EspaisServeisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais-serveis",
     *     tags={"EspaiServei"},
     *     summary="Llista totes les associacions entre espais i serveis",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les associacions entre espais i serveis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaiServei")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $espaisServeis = EspaisServeis::all();
        return response()->json(['espais_serveis' => $espaisServeis], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/espais-serveis",
     *     tags={"EspaiServei"},
     *     summary="Crea una nova associació entre un espai i un servei",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"servei_id", "espai_id"},
     *             @OA\Property(property="servei_id", type="integer", example=1),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiServei")
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
            'servei_id' => 'required|exists:serveis,id',
            'espai_id' => 'required|exists:espais,id',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $espaiServei = EspaisServeis::create($request->all());
        return response()->json(['espai_servei' => $espaiServei], 200);
    }

    // Continuació de EspaisServeisController

/**
 * @OA\Get(
 *     path="/api/espais-serveis/{servei_id}/{espai_id}",
 *     tags={"EspaiServei"},
 *     summary="Mostra una associació específica entre espai i servei",
 *     @OA\Parameter(
 *         name="servei_id",
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
 *         description="Retorna la associació específica",
 *         @OA\JsonContent(ref="#/components/schemas/EspaiServei")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Associació no trobada")
 *         )
 *     )
 * )
 */
public function show($servei_id, $espai_id)
{
    $espaiServei = EspaisServeis::where('servei_id', $servei_id)->where('espai_id', $espai_id)->first();
    if (!$espaiServei) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }
    return response()->json(['espai_servei' => $espaiServei], 200);
}

// Com que l'associació entre un espai i un servei no sol requerir actualitzacions, no implementarem el mètode update.

/**
 * @OA\Delete(
 *     path="/api/espais-serveis/{servei_id}/{espai_id}",
 *     tags={"EspaiServei"},
 *     summary="Elimina una associació específica entre espai i servei",
 *     @OA\Parameter(
 *         name="servei_id",
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
 *         description="Associació eliminada correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Associació eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Associació no trobada")
 *         )
 *     )
 * )
 */
public function destroy($servei_id, $espai_id)
{
    $espaiServei = EspaisServeis::where('servei_id', $servei_id)->where('espai_id', $espai_id)->first();
    if (!$espaiServei) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }

    $espaiServei->delete();
    return response()->json(['message' => 'Associació eliminada correctament'], 200);
}
}

