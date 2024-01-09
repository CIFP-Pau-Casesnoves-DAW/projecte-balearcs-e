<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalitats;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Modalitat",
 *     description="Operacions per a Modalitats"
 * )
 */
class ModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/modalitats",
     *     tags={"Modalitat"},
     *     summary="Llista totes les modalitats",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les modalitats",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Modalitat")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $modalitats = Modalitats::all();
        return response()->json(['modalitats' => $modalitats], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/modalitats",
     *     tags={"Modalitat"},
     *     summary="Crea una nova modalitat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nom_modalitat"},
     *             @OA\Property(property="nom_modalitat", type="string", example="Pintura")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
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
            'nom_modalitat' => 'required|string|max:255'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $modalitat = Modalitats::create($request->all());
        return response()->json(['modalitat' => $modalitat], 200);
    }

    // Continuació de ModalitatsController

/**
 * @OA\Get(
 *     path="/api/modalitats/{id}",
 *     tags={"Modalitat"},
 *     summary="Mostra una modalitat específica",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la modalitat específica",
 *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     )
 * )
 */
public function show($id)
{
    $modalitat = Modalitats::find($id);
    if (!$modalitat) {
        return response()->json(['message' => 'Modalitat no trobada'], 404);
    }
    return response()->json(['modalitat' => $modalitat], 200);
}

/**
 * @OA\Put(
 *     path="/api/modalitats/{id}",
 *     tags={"Modalitat"},
 *     summary="Actualitza una modalitat específica",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom_modalitat"},
 *             @OA\Property(property="nom_modalitat", type="string", example="Escultura")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat actualitzada correctament",
 *         @OA\JsonContent(ref="#/components/schemas/Modalitat")
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
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     )
 * )
 */
public function update(Request $request, $id)
{
    $reglesValidacio = [
        'nom_modalitat' => 'required|string|max:255'
    ];

    $validacio = Validator::make($request->all(), $reglesValidacio);
    if ($validacio->fails()) {
        return response()->json(['errors' => $validacio->errors()], 400);
    }

    $modalitat = Modalitats::find($id);
    if (!$modalitat) {
        return response()->json(['message' => 'Modalitat no trobada'], 404);
    }

    $modalitat->update($request->all());
    return response()->json(['modalitat' => $modalitat], 200);
}

/**
 * @OA\Delete(
 *     path="/api/modalitats/{id}",
 *     tags={"Modalitat"},
 *     summary="Elimina una modalitat específica",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat eliminada correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Modalitat eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     )
 * )
 */
public function destroy($id)
{
    $modalitat = Modalitats::find($id);
    if (!$modalitat) {
        return response()->json(['message' => 'Modalitat no trobada'], 404);
    }

    $modalitat->delete();
    return response()->json(['message' => 'Modalitat eliminada correctament'], 200);
}

}


