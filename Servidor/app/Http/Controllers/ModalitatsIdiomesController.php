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
 *     path="/modalitats-idiomes",
 *     summary="Obté una llista de totes les modalitats d'idiomes",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna una llista de totes les modalitats d'idiomes",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="modalitats_idiomes",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/ModalitatIdioma")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en el servidor"
 *     )
 * )
 * @OA\Schema(
 *     schema="ModalitatIdioma",
 *     type="object",
 *     @OA\Property(property="idioma_id", type="integer", example="1"),
 *     @OA\Property(property="modalitat_id", type="integer", example="1"),
 *     @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *     
 * )
 */

    public function index()
    {
        $modalitats_idiomes = ModalitatsIdiomes::all();
        return response()->json(['modalitats_idiomes' => $modalitats_idiomes]);
    }

  /**
 * @OA\Post(
 *     path="/modalitats-idiomes",
 *     summary="Crea una nova modalitat-idioma",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear una nova modalitat-idioma",
 *         @OA\JsonContent(
 *             required={"idioma_id", "modalitat_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="string", example="1"),
 *             @OA\Property(property="modalitat_id", type="string", example="1"),
 *             @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Modalitat-idioma creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat-idioma creada correctament"),
 *             @OA\Property(property="modalitat_idioma", ref="#/components/schemas/ModalitatIdioma")
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
 *     path="/modalitats-idiomes/{modalitat_idioma}",
 *     summary="Obté una modalitat d'idioma específica",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\Parameter(
 *         name="modalitat_idioma",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat d'idioma",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la modalitat d'idioma especificada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="modalitat_idioma", ref="#/components/schemas/ModalitatIdioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat d'idioma no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat d'idioma no trobada")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="ModalitatIdioma",
 *     type="object",
 *     @OA\Property(property="idioma_id", type="integer", example="1"),
 *     @OA\Property(property="modalitat_id", type="integer", example="1"),
 *     @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *      
 *     
 * )
 */
    public function show(ModalitatsIdiomes $modalitat_idioma)
    {
        return response()->json(['modalitat_idioma' => $modalitat_idioma]);
    }

     /**
 * @OA\Put(
 *     path="/modalitats-idiomes/{modalitat_idioma}",
 *     summary="Actualitza una modalitat d'idioma específica",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\Parameter(
 *         name="modalitat_idioma",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat d'idioma a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la modalitat d'idioma",
 *         @OA\JsonContent(
 *             required={"idioma_id", "modalitat_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="string", example="1"),
 *             @OA\Property(property="modalitat_id", type="string", example="1"),
 *             @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat d'idioma actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat-idioma actualitzada correctament"),
 *             @OA\Property(property="modalitat_idioma", ref="#/components/schemas/ModalitatIdioma")
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
 *         description="Modalitat d'idioma no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat d'idioma no trobada")
 *         )
 *     )
 * )
 *   @OA\Schema(
 *     schema="ModalitatIdioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="idioma_id", type="string", example="1"),
 *     @OA\Property(property="modalitat_id", type="string", example="1"),
 *     @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
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
 *     path="/modalitats-idiomes/{modalitat_idioma}",
 *     summary="Elimina una modalitat d'idioma específica",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\Parameter(
 *         name="modalitat_idioma",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat d'idioma a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat d'idioma eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat-idioma eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat d'idioma no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat d'idioma no trobada")
 *         )
 *     )
 * )
 */
    public function destroy(ModalitatsIdiomes $modalitat_idioma)
    {
        $modalitat_idioma->delete();
        return response()->json(['message' => 'Modalitat-idioma eliminada correctamente']);
    }
}
