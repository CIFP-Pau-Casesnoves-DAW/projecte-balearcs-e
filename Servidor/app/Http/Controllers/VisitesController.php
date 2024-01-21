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
 *     path="/visites",
 *     summary="Llista totes les visites",
 *     tags={"Visites"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna un llistat de totes les visites",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Visita")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Visita",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="títol", type="string", example="Visita Guiada al Museu"),
 *     @OA\Property(property="descripcio", type="string", example="Recorregut pel museu amb guia especialitzat"),
 *     @OA\Property(property="data_inici", type="string", format="date", example="2024-05-01"),
 *     @OA\Property(property="data_fi", type="string", format="date", example="2024-05-15"),
 *     @OA\Property(property="requereix_inscripcio", type="boolean", example=true),
 *     @OA\Property(property="numero_places", type="integer", example="30"),
 *     @OA\Property(property="numero_total_visites", type="integer", example="100"),
 *     @OA\Property(property="punts_interes", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="null")
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
 *     path="/visites",
 *     summary="Crea una nova visita",
 *     tags={"Visites"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a la creació d'una visita",
 *         @OA\JsonContent(
 *             required={"titol", "descripcio", "inscripcio_previa", "n_places", "data_inici", "data_fi", "horari", "espai_id"},
 *             @OA\Property(property="titol", type="string", example="Visita al Castell"),
 *             @OA\Property(property="descripcio", type="string", example="Un recorregut històric pel castell"),
 *             @OA\Property(property="inscripcio_previa", type="boolean", example=true),
 *             @OA\Property(property="n_places", type="integer", example=20),
 *             @OA\Property(property="total_visitants", type="integer", example=null),
 *             @OA\Property(property="data_inici", type="string", format="date", example="2024-06-01"),
 *             @OA\Property(property="data_fi", type="string", format="date", example="2024-06-15"),
 *             @OA\Property(property="horari", type="string", example="De 10:00 a 18:00"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example=null),
 *             @OA\Property(property="espai_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Visita creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita creada correctamente"),
 *             @OA\Property(property="visita", ref="#/components/schemas/Visita")
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
 *     path="/visites/{visita}",
 *     summary="Mostra una visita específica",
 *     tags={"Visites"},
 *     @OA\Parameter(
 *         name="visita",
 *         in="path",
 *         required=true,
 *         description="ID de la visita a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la visita específica",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="visita", ref="#/components/schemas/Visita")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita no trobada")
 *         )
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
 *     path="/visites/{visita}",
 *     summary="Actualitza una visita específica",
 *     tags={"Visites"},
 *     @OA\Parameter(
 *         name="visita",
 *         in="path",
 *         required=true,
 *         description="ID de la visita a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la visita",
 *         @OA\JsonContent(
 *             required={"titol", "descripcio", "inscripcio_previa", "n_places", "data_inici", "data_fi", "horari", "espai_id"},
 *             @OA\Property(property="titol", type="string", example="Visita al Museu d'Art"),
 *             @OA\Property(property="descripcio", type="string", example="Descripció detallada de la visita"),
 *             @OA\Property(property="inscripcio_previa", type="boolean", example=true),
 *             @OA\Property(property="n_places", type="integer", example=30),
 *             @OA\Property(property="total_visitants", type="integer", example=150),
 *             @OA\Property(property="data_inici", type="string", format="date", example="2024-05-01"),
 *             @OA\Property(property="data_fi", type="string", format="date", example="2024-05-10"),
 *             @OA\Property(property="horari", type="string", example="De 10:00 a 14:00"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="null"),
 *             @OA\Property(property="espai_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Visita actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita actualitzada correctament"),
 *             @OA\Property(property="visita", ref="#/components/schemas/Visita")
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
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita no trobada")
 *         )
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
 *     path="/visites/{visita}",
 *     summary="Elimina una visita específica",
 *     tags={"Visites"},
 *     @OA\Parameter(
 *         name="visita",
 *         in="path",
 *         required=true,
 *         description="ID de la visita a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Visita eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Visita no trobada")
 *         )
 *     )
 * )
 */
    public function destroy(Visites $visita)
    {
        $visita->delete();

        return response()->json(['message' => 'Visita eliminada correctamente']);
    }
}
