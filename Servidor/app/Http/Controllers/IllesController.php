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
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Illa")
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
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Illa",
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
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     path="/api/illes",
 *     tags={"Illes"},
 *     summary="Crea una nova illa",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de la nova illa a crear",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", example="Nom de l'illa"),
 *             @OA\Property(property="zona", type="string", example="Zona de l'illa"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Illa creada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illa")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", example={
 *                 "nom": {"El camp nom és obligatori."},
 *                 "zona": {"El camp zona ha de tenir màxim 255 caràcters."},
 *                 "data_baixa": {"El camp data_baixa ha de ser una data vàlida."}
 *             })
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
 *
 */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'zona' => 'required|string|max:255',
                'data_baixa' => 'nullable|date',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Illes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illa")
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
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 *
 */
    public function show($id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
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
 *     summary="Actualitza les dades d'una illa existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'illa a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'illa a actualitzar",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", example="Nou nom de l'illa"),
 *             @OA\Property(property="zona", type="string", example="Nova zona de l'illa"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'illa actualitzades amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illa")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", example={
 *                 "nom": {"El camp nom ha de ser una cadena de text."},
 *                 "zona": {"El camp zona és obligatori."},
 *                 "data_baixa": {"El camp data_baixa ha de ser una data vàlida."}
 *             })
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
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
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 *
 */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Illes::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'zona' => 'nullable|string|max:255',
                'data_baixa' => 'nullable|date',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
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
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Illa")
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
 *             @OA\Property(property="message", type="string")
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
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
