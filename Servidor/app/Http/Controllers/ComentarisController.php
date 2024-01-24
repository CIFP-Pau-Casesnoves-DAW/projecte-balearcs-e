<?php

namespace App\Http\Controllers;

use App\Models\Comentaris;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
     * @OA\Tag(
     *    name="Comentaris",
     *   description="Operacions per a Comentaris"
     * )
     */
class ComentarisController extends Controller
{
    
     /**
 * @OA\Get(
 *     path="/api/comentaris",
 *     tags={"Comentaris"},
 *     summary="Llista tots els comentaris",
 *     @OA\Response(
 *         response=200,
 *         description="Llista de comentaris recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Comentaris")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Comentari no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Comentari no trobat")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Comentaris",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic del comentari"),
 *     @OA\Property(property="text", type="string", description="Text del comentari"),
 *     @OA\Property(property="usuari_id", type="integer", description="Identificador de l'usuari que ha fet el comentari"),
 *     @OA\Property(property="audio_id", type="integer", description="Identificador de l'audio al qual pertany el comentari"),
 *     @OA\Property(property="creat_a", type="string", format="date-time", description="Data i hora de creació del comentari")
 * )
 */

    public function index()
    {
        try {
            $tuples = Comentaris::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Comentari no trobat'], 400);
        }
    }

    /**
 * @OA\Post(
 *     path="/api/comentaris",
 *     tags={"Comentaris"},
 *     summary="Crea un nou comentari",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou comentari",
 *         @OA\JsonContent(
 *             required={"comentari", "espai_id"},
 *             @OA\Property(property="comentari", type="string", description="Text del comentari", maxLength=2000),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat al comentari"),
 *             @OA\Property(property="md_id", type="integer", description="Identificador de l'usuari que fa el comentari (opcional)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nou comentari creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcte"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Comentaris")
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
            $mdId = $request->md_id;

            $request->merge(['data' => Carbon::now()]);
            $request->merge(['usuari_id' => $mdId]);

            $reglesValidacio = [
                'comentari' => 'required|string|max:2000',
                'espai_id' => 'required|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Comentaris::create($request->all());

            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/comentaris/{id}",
 *     tags={"Comentaris"},
 *     summary="Obté les dades d'un comentari específic",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del comentari",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades del comentari trobades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Comentaris")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Comentari no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="No trobat")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $tupla = Comentaris::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
        }
    }

/**
 * @OA\Put(
 *     path="/api/comentaris/{id}",
 *     tags={"Comentaris"},
 *     summary="Actualitza un comentari existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del comentari a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades del comentari a actualitzar",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="comentari", type="string", description="Text del comentari", maxLength=2000),
 *             @OA\Property(property="espai_id", type="integer", description="Identificador de l'espai associat al comentari"),
 *             @OA\Property(property="validat", type="boolean", description="Estat de validació del comentari (només administradors)"),
 *             @OA\Property(property="usuari_id", type="integer", description="Identificador de l'usuari que ha fet el comentari (només administradors)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades del comentari actualitzades correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Comentaris")
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
            $tupla = Comentaris::findOrFail($id);

            $reglesValidacio = [
                'comentari' => 'nullable|string|max:2000',
                'espai_id' => 'nullable|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('validat') && $mdRol == 'administrador') {
                $comentari = Comentaris::find($id);
                $comentari->validat = $request->input('validat');
                $comentari->save();
            }

            if ($request->filled('usuari_id') && $mdRol == 'administrador') {
                $comentari = Comentaris::find($id);
                $comentari->usuari_id = $request->input('usuari_id');
                $comentari->save();
            }

            $request->merge(['data' => Carbon::now()]);
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
 *     path="/api/comentaris/{id}",
 *     tags={"Comentaris"},
 *     summary="Elimina un comentari existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic del comentari a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comentari eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Comentaris")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Comentari no trobat o error en l'eliminació",
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
            $comentari = Comentaris::findOrFail($id);
            $comentari->delete();
            return response()->json(['status' => 'success', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}