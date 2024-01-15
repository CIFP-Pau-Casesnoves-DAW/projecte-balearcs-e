<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModalitatsIdiomes;

/**
 * @OA\Tag(
 *     name="ModalitatsIdiomes",
 *     description="Operacions per a les modalitats d'idiomes"
 * )
 */

class ModalitatsIdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/modalitatsidiomes",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Llista totes les modalitats d'idiomes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de modalitats d'idiomes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ModalitatsIdiomes")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $modalitats_idiomes = ModalitatsIdiomes::all();
        return response()->json(['modalitats_idiomes' => $modalitats_idiomes]);
    }

    /**
     * @OA\Post(
     *     path="/api/modalitatsidiomes",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Crea una nova modalitat-idioma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|string|max:2',
            'modalitat_id' => 'required|string|max:2',
            'traduccio' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $modalitat_idioma = ModalitatsIdiomes::create($request->all());

        return response()->json(['message' => 'Modalitat-idioma creada correctamente', 'modalitat_idioma' => $modalitat_idioma]);
    }

    /**
     * @OA\Get(
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Mostra una modalitat-idioma específica",
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
     *         description="Retorna la modalitat-idioma especificada",
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     )
     * )
     */
    public function show(ModalitatsIdiomes $modalitat_idioma)
    {
        return response()->json(['modalitat_idioma' => $modalitat_idioma]);
    }

    /**
     * @OA\Put(
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Actualitza una modalitat-idioma específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, ModalitatsIdiomes $modalitat_idioma)
    {
        $request->validate([
            'idioma_id' => 'required|string|max:2',
            'modalitat_id' => 'required|string|max:2',
            'traduccio' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $modalitat_idioma->update($request->all());

        return response()->json(['message' => 'Modalitat-idioma actualitzada correctament', 'modalitat_idioma' => $modalitat_idioma]);
    }

    /**
     * @OA\Delete(
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Elimina una modalitat-idioma específica",
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
     *         description="Modalitat-idioma eliminada correctament"
     *     )
     * )
     */
    public function destroy(ModalitatsIdiomes $modalitat_idioma)
    {
        $modalitat_idioma->delete();
        return response()->json(['message' => 'Modalitat-idioma eliminada correctamente']);
    }
}
