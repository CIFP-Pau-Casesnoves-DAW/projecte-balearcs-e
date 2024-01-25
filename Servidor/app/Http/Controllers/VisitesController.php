<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visites;
use Illuminate\Support\Facades\Validator;

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
 *         description="Llista de visites recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Visites")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Visites",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic de la visita"),
 *     @OA\Property(property="titol", type="string", description="Títol de la visita"),
 *     @OA\Property(property="descripcio", type="string", description="Descripció de la visita"),
 *     @OA\Property(property="inscripcio_previa", type="boolean", description="Indica si la visita requereix inscripció prèvia"),
 *     @OA\Property(property="n_places", type="integer", description="Nombre de places de la visita"),
 *     @OA\Property(property="total_visitants", type="integer", description="Nombre total de visitants de la visita"),
 *     @OA\Property(property="data_inici", type="string", format="date", description="Data d'inici de la visita"),
 *     @OA\Property(property="data_fi", type="string", format="date", description="Data de fi de la visita"),
 *     @OA\Property(property="horari", type="string", description="Horari de la visita"),
 *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de la visita"),
 *     @OA\Property(property="espai_id", type="integer", description="Identificador únic de l'espai"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació del registre"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Data de modificació del registre"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", description="Data de baixa del registre")
 * )
 */

    public function index()
    {
        try {
            $tuples = Visites::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *         description="Dades necessàries per a crear una nova visita",
 *         @OA\JsonContent(
 *             required={"titol", "descripcio", "inscripcio_previa", "n_places", "data_inici", "data_fi", "horari", "espai_id"},
 *             @OA\Property(property="titol", type="string", description="Títol de la visita", maxLength=255),
 *             @OA\Property(property="descripcio", type="string", description="Descripció de la visita"),
 *             @OA\Property(property="inscripcio_previa", type="boolean", description="Indica si la visita requereix inscripció prèvia"),
 *             @OA\Property(property="n_places", type="integer", description="Nombre de places disponibles per a la visita"),
 *             @OA\Property(property="total_visitants", type="integer", description="Total de visitants de la visita", nullable=true),
 *             @OA\Property(property="data_inici", type="string", format="date", description="Data d'inici de la visita"),
 *             @OA\Property(property="data_fi", type="string", format="date", description="Data de fi de la visita"),
 *             @OA\Property(property="horari", type="string", description="Horari de la visita"),
 *             @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de la visita", nullable=true),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat a la visita")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nova visita creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Visites")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'titol' => 'required|string|max:255',
                'descripcio' => 'required|string',
                'inscripcio_previa' => 'required|boolean',
                'n_places' => 'required|integer',
                'total_visitants' => 'nullable|integer',
                'data_inici' => 'required|date',
                'data_fi' => 'required|date',
                'horari' => 'required|string',
                'data_baixa' => 'nullable|date',
                'espai_id' => 'required|int',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Visites::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Obté les dades d'una visita específica",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la visita",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de la visita trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Visites")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="No trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $tupla = Visites::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Actualitza una visita existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la visita a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de la visita a actualitzar",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="titol", type="string", description="Títol de la visita", maxLength=255),
 *             @OA\Property(property="descripcio", type="string", description="Descripció detallada de la visita"),
 *             @OA\Property(property="inscripcio_previa", type="boolean", description="Indica si la visita requereix inscripció prèvia"),
 *             @OA\Property(property="n_places", type="integer", description="Nombre de places disponibles per a la visita"),
 *             @OA\Property(property="total_visitants", type="integer", description="Nombre total de visitants de la visita"),
 *             @OA\Property(property="data_inici", type="string", format="date", description="Data d'inici de la visita"),
 *             @OA\Property(property="data_fi", type="string", format="date", description="Data de fi de la visita"),
 *             @OA\Property(property="horari", type="string", description="Horari de realització de la visita"),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai on es realitza la visita")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Visita actualitzada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Visites")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        try {
            $tupla = Visites::findOrFail($id);
            $reglesValidacio = [
                'titol' => 'nullable|string|max:255',
                'descripcio' => 'nullable|string',
                'inscripcio_previa' => 'nullable|boolean',
                'n_places' => 'nullable|integer',
                'total_visitants' => 'nullable|integer',
                'data_inici' => 'nullable|date',
                'data_fi' => 'nullable|date',
                'horari' => 'nullable|string',
                'espai_id' => 'nullable|int',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $mdRol = $request->md_rol;
            if (empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = NULL;
                $tupla->save();
            }

            if (!empty($request->espai_id) && $mdRol == 'administrador') {
                $request->merge(['espai_id' => $request->espai_id]);
            } 

            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Elimina una visita",
 *     description="Elimina una visita específica de la base de dades.",
 *     @OA\Parameter(
 *         name="id",
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
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Visites")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Visita no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        try {
            $tupla = Visites::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/visites/{id}/marcarBaixa",
 *     tags={"Visites"},
 *     summary="Marca una visita com a donada de baixa",
 *     description="Actualitza la data de baixa d'una visita específica, marcant-la com a donada de baixa en el sistema.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la visita a marcar com a donada de baixa",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Visita marcada com a donada de baixa correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Visites")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Visita no trobada o error en la petició",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */

    public function delete($id)
    {
        try {
            $visites = Visites::findOrFail($id);
            $visites->data_baixa = now();
            $visites->save();
            return response()->json(['status' => 'success', 'data' => $visites], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
