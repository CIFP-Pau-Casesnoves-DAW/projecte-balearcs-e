<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Idioma",
 *     description="Operacions per a Idiomes"
 * )
 */
class IdiomesController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/idiomes",
 *     tags={"Idiomes"},
 *     summary="Llista tots els idiomes",
 *     @OA\Response(
 *         response=200,
 *         description="Llista d'idiomes recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Idioma")
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
 *     schema="Idioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic de l'idioma"),
 *     @OA\Property(property="nom", type="string", description="Nom de l'idioma"),
 *     @OA\Property(property="zona", type="string", description="Zona de l'idioma"),
 *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de l'idioma")
 * 
 * )
 */


    public function index()
    {
        try {
            $tuples = Idiomes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

 /**
 * @OA\Post(
 *     path="/api/idiomes",
 *     tags={"Idiomes"},
 *     summary="Crea un nou idioma",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou idioma",
 *         @OA\JsonContent(
 *             required={"idioma"},
 *             @OA\Property(property="idioma", type="string", description="Nom de l'idioma", maxLength=255),
 *             @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de l'idioma", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nou idioma creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Idioma")
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
                'idioma' => 'required|string|max:255',
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

            $tupla = Idiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }



    /**
 * @OA\Get(
 *     path="/api/idiomes/{id}",
 *     tags={"Idiomes"},
 *     summary="Obté les dades d'un idioma específic",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'idioma trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Idioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Idioma no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Usuaris no trobat")
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
            $tupla = Idiomes::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Put(
 *     path="/api/idiomes/{id}",
 *     tags={"Idiomes"},
 *     summary="Actualitza un idioma existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'idioma a actualitzar",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="nom", type="string", description="Nom de l'idioma", maxLength=255),
 *             @OA\Property(property="zona", type="string", description="Zona geogràfica de l'idioma", maxLength=255),
 *             @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de l'idioma", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'idioma actualitzades correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Idioma")
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
            $tupla = Idiomes::findOrFail($id);
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
 * @OA\Delete(
 *     path="/api/idiomes/{id}",
 *     tags={"Idiomes"},
 *     summary="Elimina un idioma existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Idioma eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Idioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Idioma no trobat o error en l'eliminació",
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
            $tupla = Idiomes::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}