<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visites;


/**
 * @OA\Tag(
 *     name="Visites",
 *     description="Operacions per a Visites"
 * )
 */
class VisitesController extends Controller
{
    /**
     * Muestra una lista de todas las visitas.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/visites",
     *     tags={"Visites"},
     *     summary="Llista totes les visites",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les visites",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Visites")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $visites = Visites::all();
        return response()->json(['visites' => $visites]);
    }

    /**
     * Almacena una nueva visita en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/visites",
     *     tags={"Visites"},
     *     summary="Crea una nova visita",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visita creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'inscripcio_previa' => 'required|boolean',
            'n_places' => 'required|integer',
            'total_visitants' => 'nullable|integer',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date',
            'horari' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $visita = Visites::create($request->all());

        return response()->json(['message' => 'Visita creada correctamente', 'visita' => $visita]);
    }

    /**
     * Muestra la visita especificada.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Mostra una visita específica",
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
     *         description="Retorna la visita especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     )
     * )
     */
    public function show(Visites $visita)
    {
        return response()->json(['visita' => $visita]);
    }

    /**
     * Actualiza la visita especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Actualitza una visita específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Visites")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visita actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, Visites $visita)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'inscripcio_previa' => 'required|boolean',
            'n_places' => 'required|integer',
            'total_visitants' => 'nullable|integer',
            'data_inici' => 'required|date',
            'data_fi' => 'required|date',
            'horari' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $visita->update($request->all());

        return response()->json(['message' => 'Visita actualizada correctamente', 'visita' => $visita]);
    }

    /**
     * Elimina la visita especificada de la base de datos.
     *
     * @param  \App\Models\Visites  $visita
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/visites/{id}",
     *     tags={"Visites"},
     *     summary="Elimina una visita específica",
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
     *         description="Visita eliminada correctament"
     *     )
     * )
     */
    public function destroy(Visites $visita)
    {
        $visita->delete();

        return response()->json(['message' => 'Visita eliminada correctamente']);
    }
}
