<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Illes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Illes",
 *     description="Operacions relacionades amb les Illes"
 * )
 */
class IllesController extends Controller
{
    /**
     * Muestra una lista de todas las islas.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Llista totes les illes",
     *     @OA\Response(
     *         response=200,
     *         description="Llista d'illes recuperada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Illes")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object", example={
     *                 "camp_1": {"El camp 1 és obligatori."},
     *                 "camp_2": {"El camp 2 ha de ser una cadena de text."}
     *             })
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Illes",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="Identificador únic de l'illa"),
     *     @OA\Property(property="nom", type="string", description="Nom de l'illa"),
     *     @OA\Property(property="zona", type="string", description="Zona de l'illa"),
     *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de l'illa", nullable=true)
     * )
     */

    public function index()
    {
        try {
            $tuples = Illes::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena una nueva isla en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *   path="/api/illes",
     *   summary="Crea una nova illa",
     *   description="Aquest endpoint permet crear una nova illa amb les dades proporcionades.",
     *   operationId="storeIlla",
     *   tags={"Illes"},
     *   @OA\RequestBody(
     *     required=true,
     *     description="Dades de la nova illa",
     *     @OA\JsonContent(
     *       required={"nom", "zona"},
     *       @OA\Property(property="nom", type="string", example="Mallorca", description="El nom de l'illa"),
     *       @OA\Property(property="zona", type="string", example="Llevant", description="La zona de l'illa"),
     *       @OA\Property(property="data_baixa", type="string", format="date-time", example="2024-01-24T00:00:00", description="Data de baixa de l'illa (opcional)")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Illa creada amb èxit",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="success"),
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/Illes")
     *     )
     *   ),
     *   @OA\Response(
     *     response=400,
     *     description="Error de validació",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="error"),
     *       @OA\Property(property="data", type="object", description="Detalls dels errors de validació")
     *     )
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Error intern del servidor",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="error"),
     *       @OA\Property(property="data", type="string", description="Missatge d'error")
     *     )
     *   )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'zona' => 'required|string|max:255',

            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }
            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
            }

            $tupla = Illes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la isla especificada.
     *
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */


    /**
     * @OA\Get(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Obté les dades d'una illa específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'illa",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades de l'illa trobades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Illa no trobada",
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     *
     */
    public function show($id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza la isla especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */


    /**
     * @OA\Put(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Actualitza una illa",
     *     operationId="updateIlla",
     *     description="Actualitza les dades d'una illa existent. Només els camps proporcionats seran actualitzats.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la illa a actualitzar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Dades de la illa per actualitzar",
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Illes"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illa actualitzada amb èxit",
     *         @OA\JsonContent(ref="#/components/schemas/Illes")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Petició incorrecta o error en la validació de dades"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Illa no trobada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'filled|string|max:255',
                'zona' => 'filled|string|max:255',

            ];
            $missatges = [
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }
            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
            }

            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Elimina la isla especificada de la base de datos.
     *
     * @param  \App\Models\Illes  $illa
     * @return \Illuminate\Http\Response
     */


    /**
     * @OA\Delete(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Elimina una illa existent",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'illa a eliminar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illa eliminada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Illa no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Illa no trobada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     *
     */
    public function destroy($id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
