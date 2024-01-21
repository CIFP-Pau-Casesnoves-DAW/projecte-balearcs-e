<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesIdiomes;

/**
 * @OA\Tag(
 *     name="VisitesIdiomes",
 *     description="Operacions per a Visites Idiomes"
 * )
 */
class VisitesIdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/visitesidiomes",
     *     tags={"VisitesIdiomes"},
     *     summary="Llista totes les traduccions de visites",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de les traduccions de visites",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/VisitesIdiomes")
     *         )
     *     )
     */
    public function index()
    {
        $visitesIdiomes = VisitesIdiomes::all();
        return response()->json(['visites_idiomes' => $visitesIdiomes]);
    }

    /**
     * @OA\Post(
     *     path="/api/visitesidiomes",
     *     tags={"VisitesIdiomes"},
     *     summary="Crea una nova traducció de visita",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VisitesIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció de visita creada correctament"
     *     )
     */
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'visita_id' => 'required|exists:visites,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaIdioma = VisitesIdiomes::create($request->all());

        return response()->json(['message' => 'Traducción de visita creada correctamente', 'visita_idioma' => $visitaIdioma]);
    }

    /**
     * @OA\Get(
     *     path="/api/visitesidiomes/{id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Mostra una traducció de visita específica",
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
     *         description="Retorna la traducció de visita especificada",
     *         @OA\JsonContent(ref="#/components/schemas/VisitesIdiomes")
     *     )
     */
    public function show(VisitesIdiomes $visitaIdioma)
    {
        return response()->json(['visita_idioma' => $visitaIdioma]);
    }

    /**
     * @OA\Put(
     *     path="/api/visitesidiomes/{id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Actualitza una traducció de visita específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/VisitesIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció de visita actualitzada correctament"
     *     )
     */
    public function update(Request $request, VisitesIdiomes $visitaIdioma)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'visita_id' => 'required|exists:visites,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaIdioma->update($request->all());

        return response()->json(['message' => 'Traducción de visita actualizada correctamente', 'visita_idioma' => $visitaIdioma]);
    }

    /**
     * @OA\Delete(
     *     path="/api/visitesidiomes/{id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Elimina una traducció de visita específica",
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
     *         description="Traducció de visita eliminada correctament"
     *     )
     */
    public function destroy(VisitesIdiomes $visitaIdioma)
    {
        $visitaIdioma->delete();

        return response()->json(['message' => 'Traducción de visita eliminada correctamente']);
    }
}
