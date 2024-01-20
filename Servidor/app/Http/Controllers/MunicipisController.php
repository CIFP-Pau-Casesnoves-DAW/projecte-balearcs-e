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
 *     path="/municipis",
 *     summary="Obté llista de tots els municipis",
 *     tags={"Municipis"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de municipis",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Municipi")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Municipi",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="illa_id", type="integer"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true)
 *     // Altres propietats del model Municipi segons la teva base de dades
 * )
 */
    public function index()
    {
        $municipis = Municipis::all();
        return response()->json(['municipis' => $municipis]);
    }

    /**
 * @OA\Post(
 *     path="/municipis",
 *     summary="Crea un nou municipi",
 *     tags={"Municipis"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades del nou municipi",
 *         @OA\JsonContent(
 *             required={"nom", "illa_id"},
 *             @OA\Property(property="nom", type="string", example="Palma"),
 *             @OA\Property(property="illa_id", type="integer", example=1),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi creat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi creat correctament"),
 *             @OA\Property(property="municipi", ref="#/components/schemas/Municipi")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Municipi",
 *     type="object",
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="illa_id", type="integer"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true)
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
 *     path="/municipis/{municipi}",
 *     summary="Mostra un municipi específic",
 *     tags={"Municipis"},
 *     @OA\Parameter(
 *         name="municipi",
 *         in="path",
 *         required=true,
 *         description="ID del municipi a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi mostrat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="municipi", ref="#/components/schemas/Municipi")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Municipi no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi no trobat")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Municipi",
 *     type="object",
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="illa_id", type="integer"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true)
 * )
 */

    public function show(Municipis $municipi)
    {
        return response()->json(['municipi' => $municipi]);
    }

   /**
 * @OA\Put(
 *     path="/municipis/{municipi}",
 *     summary="Actualitza un municipi específic",
 *     tags={"Municipis"},
 *     @OA\Parameter(
 *         name="municipi",
 *         in="path",
 *         required=true,
 *         description="ID del municipi a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar el municipi",
 *         @OA\JsonContent(
 *             required={"nom", "illa_id"},
 *             @OA\Property(property="nom", type="string", example="Palma"),
 *             @OA\Property(property="illa_id", type="integer", example="1"),
 *             @OA\Property(property="data_baixa", type="string", format="date", nullable=true, example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi actualitzat correctament"),
 *             @OA\Property(property="municipi", ref="#/components/schemas/Municipi")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Municipi no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi no trobat")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Municipi",
 *     type="object",
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="illa_id", type="integer"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true)
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
 *     path="/municipis/{municipi}",
 *     summary="Elimina un municipi específic",
 *     tags={"Municipis"},
 *     @OA\Parameter(
 *         name="municipi",
 *         in="path",
 *         required=true,
 *         description="ID del municipi a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi eliminat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Municipi no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Municipi no trobat")
 *         )
 *     )
 * )
 */
    public function destroy(Municipis $municipi)
    {
        $municipi->delete();
        return response()->json(['message' => 'Municipi eliminat correctament']);
    }
}
