<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaiModalitat;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiModalitat",
 *     description="Operacions per a Modalitats d'Espais"
 * )
 */
class EspaisModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais-modalitats",
     *     tags={"EspaiModalitat"},
     *     summary="Llista totes les modalitats dels espais",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les modalitats dels espais",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaiModalitat")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $espaisModalitats = EspaiModalitat::all();
        return response()->json(['espais_modalitats' => $espaisModalitats], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/espais-modalitats",
     *     tags={"EspaiModalitat"},
     *     summary="Crea una nova associació entre un espai i una modalitat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"espai_id", "modalitat_id"},
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="modalitat_id", type="integer", example=1),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiModalitat")
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
            'espai_id' => 'required|exists:espais,id',
            'modalitat_id' => 'required|exists:modalitats,id',
            'data_baixa' => 'nullable|date',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $espaiModalitat = EspaiModalitat::create($request->all());
        return response()->json(['espai_modalitat' => $espaiModalitat], 200);
    }

    

/**
 * @OA\Get(
 *     path="/api/espais-modalitats/{espai_id}/{modalitat_id}",
 *     tags={"EspaiModalitat"},
 *     summary="Mostra una associació específica entre espai i modalitat",
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la associació específica",
 *         @OA\JsonContent(ref="#/components/schemas/EspaiModalitat")
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
public function show($espai_id, $modalitat_id)
{
    $espaiModalitat = EspaiModalitat::where('espai_id', $espai_id)->where('modalitat_id', $modalitat_id)->first();
    if (!$espaiModalitat) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }
    return response()->json(['espai_modalitat' => $espaiModalitat], 200);
}

// El mètode update no és comú per a aquest tipus d'associacions, ja que normalment es crea o elimina.

/**
 * @OA\Delete(
 *     path="/api/espais-modalitats/{espai_id}/{modalitat_id}",
 *     tags={"EspaiModalitat"},
 *     summary="Elimina una associació específica entre espai i modalitat",
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
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
public function destroy($espai_id, $modalitat_id)
{
    $espaiModalitat = EspaiModalitat::where('espai_id', $espai_id)->where('modalitat_id', $modalitat_id)->first();
    if (!$espaiModalitat) {
        return response()->json(['message' => 'Associació no trobada'], 404);
    }

    $espaiModalitat->delete();
    return response()->json(['message' => 'Associació eliminada correctament'], 200);
}

}

