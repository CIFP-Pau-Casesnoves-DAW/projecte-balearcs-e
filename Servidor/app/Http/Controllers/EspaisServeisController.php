<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaiServei;
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
 *     path="/espais-serveis",
 *     summary="Llista totes les associacions d'espais i serveis",
 *     tags={"EspaiServei"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista d'associacions d'espais i serveis",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="espais_serveis",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/EspaiServei")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="EspaiServei",
 *     type="object",
 *     @OA\Property(property="espai_id", type="integer", example=1),
 *     @OA\Property(property="servei_id", type="integer", example=2),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 * 
 *     
 * )
 */
    public function index()
    {
        $espaisServeis = EspaiServei::all();
        return response()->json(['espais_serveis' => $espaisServeis], 200);
    }

    /**
 * @OA\Post(
 *     path="/espais-serveis",
 *     summary="Crea una nova associació entre un espai i un servei",
 *     tags={"EspaiServei"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear una nova associació",
 *         @OA\JsonContent(
 *             required={"servei_id", "espai_id"},
 *             @OA\Property(property="servei_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=2),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="espai_servei", type="object", ref="#/components/schemas/EspaiServei")
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
 * @OA\Schema(
 *     schema="EspaiServei",
 *     type="object",
 *     @OA\Property(property="servei_id", type="integer", example=1),
 *     @OA\Property(property="espai_id", type="integer", example=2),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 * 
 *     
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

        $espaiServei = EspaiServei::create($request->all());
        return response()->json(['espai_servei' => $espaiServei], 200);
    }

    /**
 * @OA\Get(
 *     path="/espais-serveis/{servei_id}/{espai_id}",
 *     summary="Obté una associació específica entre un espai i un servei",
 *     tags={"EspaiServei"},
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
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
 *         description="Associació trobada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="espai_servei", type="object", ref="#/components/schemas/EspaiServei")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Associació no trobada")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="EspaiServei",
 *     type="object",
 *     @OA\Property(property="servei_id", type="integer", example=1),
 *     @OA\Property(property="espai_id", type="integer", example=2),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 * 
 *     
 * )
 */
public function show($servei_id, $espai_id)
{
    $espaiServei = EspaiServei::where('servei_id', $servei_id)->where('espai_id', $espai_id)->first();
    if (!$espaiServei) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }
    return response()->json(['espai_servei' => $espaiServei], 200);
}

// Com que l'associació entre un espai i un servei no sol requerir actualitzacions, no implementarem el mètode update.

/**
 * @OA\Delete(
 *     path="/espais-serveis/{servei_id}/{espai_id}",
 *     summary="Elimina una associació entre un espai i un servei",
 *     tags={"EspaiServei"},
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
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
 *         description="Associació eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Associació eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Associació no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Associació no trobada")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="EspaiServei",
 *     type="object",
 *     @OA\Property(property="servei_id", type="integer", example=1),
 *     @OA\Property(property="espai_id", type="integer", example=2),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *     // Aquí es poden afegir altres propietats del model EspaiServei.
 * )
 */
public function destroy($servei_id, $espai_id)
{
    $espaiServei = EspaiServei::where('servei_id', $servei_id)->where('espai_id', $espai_id)->first();
    if (!$espaiServei) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }

    $espaiServei->delete();
    return response()->json(['message' => 'Associació eliminada correctament'], 200);
}
}

