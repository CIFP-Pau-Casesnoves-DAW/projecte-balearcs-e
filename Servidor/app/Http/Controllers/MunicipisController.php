<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipis;

/**
 * @OA\Tag(
 *     name="Municipis",
 *     description="Operacions per a Municipis"
 * )
 */

class MunicipisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/municipis",
     *     tags={"Municipis"},
     *     summary="Llista tots els municipis",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els municipis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Municipis")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $municipis = Municipis::all();
        return response()->json(['municipis' => $municipis]);
    }

    /**
     * @OA\Post(
     *     path="/api/municipis",
     *     tags={"Municipis"},
     *     summary="Crea un nou municipi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Municipi creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'illa_id' => 'required|integer',
            'data_baixa' => 'nullable|date',
        ]);

        $municipi = Municipis::create($request->all());

        return response()->json(['message' => 'Municipi creat correctament', 'municipi' => $municipi]);
    }

    /**
     * @OA\Get(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Mostra un municipi específic",
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
     *         description="Retorna el municipi especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     )
     * )
     */
    public function show(Municipis $municipi)
    {
        return response()->json(['municipi' => $municipi]);
    }

    /**
     * @OA\Put(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Actualitza un municipi específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Municipis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Municipi actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, Municipis $municipi)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'illa_id' => 'required|integer',
            'data_baixa' => 'nullable|date',
        ]);

        $municipi->update($request->all());

        return response()->json(['message' => 'Municipi actualitzat correctament', 'municipi' => $municipi]);
    }

    /**
     * @OA\Delete(
     *     path="/api/municipis/{id}",
     *     tags={"Municipis"},
     *     summary="Elimina un municipi específic",
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
     *         description="Municipi eliminat correctament"
     *     )
     * )
     */
    public function destroy(Municipis $municipi)
    {
        $municipi->delete();
        return response()->json(['message' => 'Municipi eliminat correctament']);
    }
}
