<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalitats;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Modalitats",
 *     description="Operacions per a Modalitats"
 * )
 */
class ModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/modalitats",
     *     tags={"Modalitats"},
     *     summary="Llista totes les modalitats",
     *     @OA\Response(
     *         response=200,
     *         description="Llista de modalitats recuperada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Modalitats")
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
     *     schema="Modalitats",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="Identificador únic de la modalitat"),
     *     @OA\Property(property="nom", type="string", description="Nom de la modalitat"),
     *     @OA\Property(property="descripcio", type="string", description="Descripció de la modalitat"),
     *     @OA\Property(property="data_creacio", type="string", format="date", description="Data de creació de la modalitat", nullable=true)
     * )
     */
    public function index()
    {
        try {
            $tuples = Modalitats::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/modalitats",
     *     tags={"Modalitats"},
     *     summary="Afegeix una nova modalitat",
     *     operationId="storeModalitat",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades de la nova modalitat",
     *         @OA\JsonContent(
     *             required={"nom_modalitat"},
     *             @OA\Property(property="nom_modalitat", type="string", maxLength=255, example="Pintura"),
     *             @OA\Property(property="data_baixa", type="string", format="date-time", example="2024-01-24T17:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat creada amb èxit",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="nom_modalitat", type="string", example="Pintura")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     ),
     *     
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom_modalitat' => 'required|string|max:255',

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
            $tupla = Modalitats::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/modalitats/{id}",
     *     tags={"Modalitats"},
     *     summary="Obté les dades d'una modalitat específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de la modalitat",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades de la modalitat trobades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Modalitats")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Modalitat no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Modalitat no trobada")
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
            $tupla = Modalitats::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/modalitats/{id}",
     *     operationId="updateModalitat",
     *     tags={"Modalitats"},
     *     summary="Actualitza una modalitat existent",
     *     description="Actualitza la informació d'una modalitat basant-se en l'ID proporcionat.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la modalitat a actualitzar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades per a actualitzar la modalitat",
     *         @OA\JsonContent(
     *             required={"nom_modalitat"},
     *             @OA\Property(property="nom_modalitat", type="string", example="Pintura"),
     *             @OA\Property(property="data_baixa", type="string", format="date-time", example="2024-01-24T14:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat actualitzada amb èxit",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Modalitats"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
     *         )
     *     ),
     *     
     * )
     */

    public function update(Request $request, $id)
    {
        try {
            $tupla = Modalitats::findOrFail($id);
            $reglesValidacio = [
                'nom_modalitat' => 'filled|string|max:255',
            ];
            $missatges = [
                'filled' => 'El camp :attribute no pot estar buit',
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
     * @OA\Delete(
     *     path="/api/modalitats/{id}",
     *     tags={"Modalitats"},
     *     summary="Elimina una modalitat existent",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de la modalitat a eliminar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat eliminada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Modalitats")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Modalitat no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Modalitat no trobada")
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
            $tupla = Modalitats::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
