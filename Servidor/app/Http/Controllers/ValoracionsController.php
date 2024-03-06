<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracions;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Valoracions",
 *     description="Operacions per a Valoracions"
 * )
 */
class ValoracionsController extends Controller
{
    /**
     * Muestra una lista de todas las valoraciones.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/valoracions",
     *     summary="Obtenir totes les valoracions",
     *     tags={"Valoracions"},
     *     @OA\Response(
     *         response=200,
     *         description="Llista de valoracions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Valoracio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Comentari no trobat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Comentari no trobat")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Valoracio",
     *     type="object",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="comentari", type="string"),
     *     @OA\Property(property="puntuacio", type="integer"),
     *     @OA\Property(property="usuari_id", type="integer"),
     *     @OA\Property(property="espai_id", type="integer"),
     *     @OA\Property(property="created_at", type="string", format="date-time"),
     *     @OA\Property(property="updated_at", type="string", format="date-time"),
     * )
     */
    public function index()
    {
        try {
            $tuples = Valoracions::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        }
    }

    /**
     * Almacena una nueva valoración en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/valoracions",
     *     summary="Crear una nova valoració",
     *     tags={"Valoracions"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear una nova valoració",
     *         @OA\JsonContent(
     *             required={"puntuacio", "espai_id", "md_id"},
     *             @OA\Property(property="puntuacio", type="integer", example=5),
     *             @OA\Property(property="data", type="string", format="date-time", example="2024-01-30T12:00:00Z"),
     *             @OA\Property(property="usuari_id", type="integer", example=1),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="data_baixa", type="string", format="date", nullable=true),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració creada correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Valoracio")
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
            $mdId = $request->md_id;

            $request->merge(['data' => Carbon::now()]);
            $request->merge(['usuari_id' => $mdId]);

            $reglesValidacio = [
                'puntuacio' => 'required|integer',
                'espai_id' => 'required|integer|exists:espais,id'
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

            $tupla = Valoracions::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Muestra la valoración especificada.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/valoracions/{id}",
     *     summary="Obtenir una valoració per ID",
     *     tags={"Valoracions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la valoració a obtenir",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració trobada correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Valoracio")
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
     *         description="Valoració no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Valoració no trobada")
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
            $tupla = Valoracions::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        }
    }

    /**
     * Actualiza la valoración especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/valoracions/{id}",
     *     summary="Actualitza una valoració existent",
     *     tags={"Valoracions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la valoració a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per actualitzar la valoració",
     *         @OA\JsonContent(
     *             required={"puntuacio", "espai_id"},
     *             @OA\Property(property="puntuacio", type="integer", example=4),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="usuari_id", type="integer", example=2, nullable=true),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-28", nullable=true),
     *             @OA\Property(property="validat", type="boolean", example=true, nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració actualitzada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Valoracio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validació de dades fallida",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Valoració no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Valoració no trobada")
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
            $tupla = Valoracions::findOrFail($id);

            $reglesValidacio = [
                'puntuacio' => 'filled|integer',
                'espai_id' => 'filled|integer|exists:espais,id',
            ];

            $missatges = [
                'filled' => 'El camp :attribute no pot estar buit',
                'exists' => ':attribute ha de existir',
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('validat') && $mdRol == 'administrador') {
                $valoracio = Valoracions::find($id);
                $valoracio->validat = $request->input('validat');
                $valoracio->save();
            }

            if ($request->filled('usuari_id') && $mdRol == 'administrador') {
                $valoracio = Valoracions::find($id);
                $valoracio->usuari_id = $request->input('usuari_id');
                $valoracio->save();
            }

            if (empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = NULL;
                $tupla->save();
            } else if (!empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = now();
                $tupla->save();
            }

            $request->merge(['data' => Carbon::now()]);
            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Elimina la valoración especificada de la base de datos.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/valoracions/{id}",
     *     summary="Esborra una valoració per ID",
     *     tags={"Valoracions"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la valoració a esborrar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració esborrada correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Valoracio")
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
     *         description="Valoració no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string", example="Valoració no trobada")
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
            $valoracio = Valoracions::findOrFail($id);
            $valoracio->delete();
            return response()->json(['status' => 'success', 'data' => $valoracio], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
