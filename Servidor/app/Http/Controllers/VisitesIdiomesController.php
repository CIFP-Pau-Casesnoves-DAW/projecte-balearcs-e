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
     * Muestra una lista de todas las traducciones de visitas.
     *
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Get(
 *     path="/visitesidiomes",
 *     summary="Llista totes les traduccions de visites",
 *     tags={"VisitesIdiomes"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna una llista de totes les traduccions de visites",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/VisitaIdioma")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="VisitaIdioma",
 *     type="object",
 *     @OA\Property(property="visita_id", type="integer", example="1"),
 *     @OA\Property(property="idioma_id", type="integer", example="1"),
 *     @OA\Property(property="traduccio", type="string", example="Visita guiada"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 * )
 */

    public function index()
    {
        $visitesIdiomes = VisitesIdiomes::all();
        return response()->json(['visites_idiomes' => $visitesIdiomes]);
    }

    /**
     * Almacena una nueva traducción de visita en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Post(
 *     path="/visitesidiomes",
 *     summary="Crea una nova traducció de visita",
 *     tags={"VisitesIdiomes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a crear una nova traducció de visita",
 *         @OA\JsonContent(
 *             required={"idioma_id", "visita_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example=1),
 *             @OA\Property(property="visita_id", type="integer", example=1),
 *             @OA\Property(property="traduccio", type="string", example="Visita guiada al museu"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de visita creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita creada correctamente"),
 *             @OA\Property(property="visita_idioma", ref="#/components/schemas/VisitaIdioma")
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
            'idioma_id' => 'required|exists:idiomes,id',
            'visita_id' => 'required|exists:visites,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $visitaIdioma = VisitesIdiomes::create($request->all());

        return response()->json(['message' => 'Traducción de visita creada correctamente', 'visita_idioma' => $visitaIdioma]);
    }

    /**
     * Muestra la traducción de visita especificada.
     *
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Get(
 *     path="/visitesidiomes/{visitaIdioma}",
 *     summary="Mostra una traducció de visita específica",
 *     tags={"VisitesIdiomes"},
 *     @OA\Parameter(
 *         name="visitaIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció de visita a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la traducció de la visita especificada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="visita_idioma", ref="#/components/schemas/VisitaIdioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció de visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita no encontrada")
 *         )
 *     )
 * )
 */

    public function show(VisitesIdiomes $visitaIdioma)
    {
        return response()->json(['visita_idioma' => $visitaIdioma]);
    }

    /**
     * Actualiza la traducción de visita especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */

  
     /**
 * @OA\Put(
 *     path="/visitesidiomes/{visitaIdioma}",
 *     summary="Actualitza una traducció de visita específica",
 *     tags={"VisitesIdiomes"},
 *     @OA\Parameter(
 *         name="visitaIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció de visita a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la traducció de la visita",
 *         @OA\JsonContent(
 *             required={"idioma_id", "visita_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example="1"),
 *             @OA\Property(property="visita_id", type="integer", example="2"),
 *             @OA\Property(property="traduccio", type="string", example="Visita guiada al museu"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de visita actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita actualizada correctamente"),
 *             @OA\Property(property="visita_idioma", ref="#/components/schemas/VisitaIdioma")
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
 *         description="Traducció de visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita no encontrada")
 *         )
 *     )
 * )
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
     * Elimina la traducción de visita especificada de la base de datos.
     *
     * @param  \App\Models\VisitesIdiomes  $visitaIdioma
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Delete(
 *     path="/visitesidiomes/{visitaIdioma}",
 *     summary="Elimina una traducció de visita específica",
 *     tags={"VisitesIdiomes"},
 *     @OA\Parameter(
 *         name="visitaIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció de visita a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de visita eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita eliminada correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció de visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de visita no encontrada")
 *         )
 *     )
 * )
 */
    public function destroy(VisitesIdiomes $visitaIdioma)
    {
        $visitaIdioma->delete();

        return response()->json(['message' => 'Traducción de visita eliminada correctamente']);
    }
}
