<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fotos;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Fotos",
 *     description="Operacions per a Fotos d'Espais i Punts d'Interès"
 * )
 */
class FotosController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/fotos",
 *     tags={"Fotos"},
 *     summary="Llista totes les fotos",
 *     @OA\Response(
 *         response=200,
 *         description="Llista de fotos recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Fotos")
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
 *     schema="Fotos",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic de la foto"),
 *     @OA\Property(property="url", type="string", description="URL de la foto"),
 *     @OA\Property(property="punt_interes_id", type="integer", description="Identificador únic del punt d'interès"),
 *     @OA\Property(property="espai_id", type="integer", description="Identificador únic de l'espai"),
 *     @OA\Property(property="comentari", type="string", description="Comentari sobre la foto", nullable=true),
 *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de la foto", nullable=true)
 *     
 * )
 */

    public function index()
    {
        try {
            $tuples = Fotos::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/api/fotos",
 *     tags={"Fotos"},
 *     summary="Crea una nova foto",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear una nova foto",
 *         @OA\JsonContent(
 *             required={"url", "punt_interes_id", "espai_id"},
 *             @OA\Property(property="url", type="string", format="uri", description="URL de la foto"),
 *             @OA\Property(property="punt_interes_id", type="integer", description="Identificador del punt d'interès associat a la foto"),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat a la foto"),
 *             @OA\Property(property="comentari", type="string", description="Comentari sobre la foto", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nova foto creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Fotos")
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
                'url' => 'required|string',
                'punt_interes_id' => 'required|exists:punts_interes,id',
                'espai_id' => 'required|exists:espais,id',
                'comentari' => 'nullable|string',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Fotos::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    

    /**
 * @OA\Get(
 *     path="/api/fotos/{id}",
 *     tags={"Fotos"},
 *     summary="Obté les dades d'una foto específica",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la foto",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de la foto trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Fotos")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Foto no trobada",
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
            $tupla = Fotos::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

/**
 * @OA\Put(
 *     path="/api/fotos/{id}",
 *     summary="Actualitza una foto",
 *     description="Actualitza les dades d'una foto existent",
 *     operationId="updateFoto",
 *     tags={"Fotos"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador de la foto",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de la foto per actualitzar",
 *         @OA\JsonContent(
 *             required={"url", "comentari", "punt_interes_id"},
 *             @OA\Property(property="url", type="string", example="http://exemple.com/foto.jpg"),
 *             @OA\Property(property="comentari", type="string", example="Comentari de la foto"),
 *             @OA\Property(property="punt_interes_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto actualitzada amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Fotos"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
            $reglesValidacio = [
                'url' => 'nullable|string',
                'comentari' => 'nullable|string',
                'punt_interes_id' => 'nullable|exists:punts_interes,id',
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
 * @OA\Delete(
 *     path="/api/fotos/{id}",
 *     tags={"Fotos"},
 *     summary="Elimina una foto existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la foto a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Fotos")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Foto no trobada o error en l'eliminació",
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
            $tupla = Fotos::findOrFail($id);
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
 *     path="/api/fotos/delete/{id}",
 *     tags={"Fotos"},
 *     summary="Marca una foto com a donada de baixa",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la foto a marcar com a baixa",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Foto marcada com a baixa correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Fotos")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Foto no trobada o error en el procés de baixa",
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
            $foto = Fotos::findOrFail($id);
            $foto->data_baixa = now();
            $foto->save();
            return response()->json(['status' => 'success', 'data' => $foto], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}