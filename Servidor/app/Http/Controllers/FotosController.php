<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fotos;
use Illuminate\Support\Facades\Storage;
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
     *             @OA\Property(property="data", type="string")
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
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */

    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'foto' => 'required|mimes:jpg,jpeg,bmp,png||max:10240',
                'punt_interes_id' => 'required|exists:punts_interes,id',
                'espai_id' => 'required|exists:espais,id',
                'comentari' => 'filled|string',
            ];
            $missatges = [
                'mimes' => 'Es requereix jpg,jpeg,bmp,png',
                'max' => 'Excedit el tamany màxim de 10240',
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
                'required' => 'El camp :attribute és obligatori.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            // Guardar la imagen utilizando Eloquent
            $fotoModelo = new Fotos();
            $fotoModelo->punt_interes_id = $request->punt_interes_id;
            $fotoModelo->espai_id = $request->espai_id;
            $fotoModelo->comentari = $request->comentari;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nombreFoto = time() . '_' . $foto->getClientOriginalName();
                $ruta = $foto->storeAs('public/fotos', $nombreFoto); 
                $fotoModelo->foto = $ruta;
            }

            $fotoModelo->save();

            return response()->json(['status' => 'success', 'data' => $fotoModelo], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
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
     *             @OA\Property(property="data", type="string")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        try {
            $tupla = Fotos::findOrFail($id);
            $arxiuFoto = $tupla->foto;
            Storage::delete($arxiuFoto);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla, 'arxiu' => $arxiuFoto], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
