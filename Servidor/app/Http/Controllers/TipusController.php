<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipus;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Tipus",
 *     description="Operacions per a Tipus"
 * )
 */
class TipusController extends Controller
{
    /**
     * Muestra una lista de todos los tipos.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/tipus",
     *     operationId="getTipus",
     *     tags={"Tipus"},
     *     summary="Obtenir tots els tipus",
     *     description="Retorna una llista de tots els tipus",
     *     @OA\Response(
     *         response=200,
     *         description="Llista de tots els tipus",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tipus")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object", example={"field_name": {"Missatge d'error"}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Missatge d'error intern del servidor")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Tipus",
     *     type="object",
     *     @OA\Property(property="nom_serveis", type="string"),
     *     @OA\Property(property="data_baixa", type="string", format="date"),
     * )
     */
    public function index()
    {
        try {
            $tuples = Tipus::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Almacena un nuevo tipo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/tipus",
     *     summary="Crea un nou tipus",
     *     tags={"Tipus"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear un nou tipus",
     *         @OA\JsonContent(
     *             required={"nom_tipus"},
     *             @OA\Property(property="nom_tipus", type="string", example="Museu"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus creat correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Tipus")
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom_tipus' => 'required|string|max:255',
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

            $tupla = Tipus::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra el tipo especificado.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/tipus/{id}",
     *     operationId="showTipus",
     *     tags={"Tipus"},
     *     summary="Obtenir un tipus per ID",
     *     description="Retorna un tipus específic basat en l'ID proporcionat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipus a obtenir",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades del tipus",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Tipus"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Missatge d'error de validació"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Missatge d'error intern del servidor"),
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Actualiza el tipo especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/tipus/{id}",
     *     summary="Actualitza un tipus d'espai per ID",
     *     tags={"Tipus"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipus d'espai a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a actualitzar el tipus d'espai",
     *         @OA\JsonContent(
     *             required={"nom_tipus"},
     *             @OA\Property(property="nom_tipus", type="string", example="Museu"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus d'espai actualitzat correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Tipus")
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
     *         response=404,
     *         description="Tipus d'espai no trobat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Tipus d'espai no trobat")
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
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            $reglesValidacio = [
                'nom_tipus' => 'filled|string|max:255',

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
     * Elimina el tipo especificado de la base de datos.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/tipus/{id}",
     *     operationId="deleteTipus",
     *     tags={"Tipus"},
     *     summary="Eliminar un tipus per ID",
     *     description="Elimina un tipus específic basat en l'ID proporcionat",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del tipus a eliminar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus eliminat amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/Tipus"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object", example={"field_name": {"Error data"}})
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error intern del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Missatge d'error intern del servidor"),
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $tupla = Tipus::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
