<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Municipis",
 *     description="Operacions per a Municipis"
 * )
 */

class MunicipisController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/municipis",
 *     tags={"Municipis"},
 *     summary="Llista tots els municipis",
 *     @OA\Response(
 *         response=200,
 *         description="Llista de municipis recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Municipi")
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
 *     schema="Municipi",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic del municipi"),
 *     @OA\Property(property="nom", type="string", description="Nom del municipi"),
 *     @OA\Property(property="provincia_id", type="integer", description="Identificador de la província a la qual pertany el municipi"),
 *     @OA\Property(property="comarca_id", type="integer", description="Identificador de la comarca a la qual pertany el municipi"),
 *     @OA\Property(property="habitants", type="integer", description="Nombre d'habitants del municipi"),
 *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa del municipi", nullable=true)
 * )
 */
    public function index()
    {
        try {
            $tuples = Municipis::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

/**
 * @OA\Post(
 *     path="/municipis",
 *     summary="Crea un nou municipi",
 *     description="Guarda un nou municipi a la base de dades",
 *     operationId="storeMunicipi",
 *     tags={"municipis"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a la creació d'un nou municipi",
 *         @OA\JsonContent(
 *             required={"nom", "illa_id"},
 *             @OA\Property(property="nom", type="string", example="Palma"),
 *             @OA\Property(property="illa_id", type="integer", example=1),
 *             @OA\Property(property="data_baixa", type="string", format="date-time", example="2024-01-24T14:00:00Z")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi creat correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Municipi"
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="No trobat"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         ),
 *     ),
 *     
 * )
 */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'illa_id' => 'required|int',
                
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.',
                'int' => 'El :attribute ha de ser un número vàlid',
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
            $tupla = Municipis::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/municipis/{id}",
 *     tags={"Municipis"},
 *     summary="Obté les dades d'un municipi específic",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del municipi",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades del municipi trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Municipi")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Municipi no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Municipi no trobat")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $tupla = Municipis::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        }
    }

/**
 * @OA\Put(
 *     path="/municipis/{id}",
 *     summary="Actualitza un municipi",
 *     description="Actualitza la informació d'un municipi existent a la base de dades.",
 *     operationId="updateMunicipi",
 *     tags={"municipis"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del municipi",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Dades del municipi per actualitzar",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom", "illa_id"},
 *             @OA\Property(property="nom", type="string", example="Palma"),
 *             @OA\Property(property="illa_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi actualitzat amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Municipi")
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
 *         description="Error del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Municipis::findOrFail($id);
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'illa_id' => 'nullable|int',
                
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.',
                'int' => 'El :attribute ha de ser un número vàlid',
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
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/municipis/{id}",
 *     tags={"Municipis"},
 *     summary="Elimina un municipi existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del municipi a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipi eliminat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error")
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
            $tupla = Municipis::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}