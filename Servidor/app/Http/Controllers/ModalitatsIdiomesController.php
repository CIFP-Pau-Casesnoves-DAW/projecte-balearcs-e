<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModalitatsIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Modalitats Idiomes",
 *     description="Operacions per a les modalitats d'idiomes"
 * )
 */

class ModalitatsIdiomesController extends Controller
{
   /**
 * @OA\Get(
 *     path="/api/modalitats-idiomes",
 *     tags={"Modalitats Idiomes"},
 *     summary="Llista totes les associacions entre modalitats i idiomes",
 *     @OA\Response(
 *         response=200,
 *         description="Llista d'associacions recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Modalitats Idiomes")
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
 *     schema="Modalitats Idiomes",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic de l'associació"),
 *     @OA\Property(property="modalitat_id", type="integer", description="Identificador de la modalitat associada"),
 *     @OA\Property(property="idioma_id", type="integer", description="Identificador de l'idioma associat"),
 *     @OA\Property(property="nivell", type="string", description="Nivell de competència en l'idioma"),
 * )
 */
    public function index()
    {
        try {
            $tuples = ModalitatsIdiomes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/api/modalitats-idiomes",
 *     tags={"Modalitats Idiomes"},
 *     summary="Crea una nova associació entre modalitats i idiomes",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'associació a crear",
 *         @OA\JsonContent(
 *             @OA\Property(property="idioma_id", type="integer", example="1"),
 *             @OA\Property(property="modalitat_id", type="integer", example="2"),
 *             @OA\Property(property="traduccio", type="string", example="Traducció de la modalitat"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació creada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Modalitats Idiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", example={
 *                 "idioma_id": {"El camp idioma_id és obligatori."},
 *                 "modalitat_id": {"El camp modalitat_id és obligatori."},
 *                 "traduccio": {"El camp traduccio ha de ser una cadena de text."},
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
                'idioma_id' => 'required|int',
                'modalitat_id' => 'required|int',
                'traduccio' => 'required|string|max:255',
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

            $tupla = ModalitatsIdiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/modalitats-idiomes/{idioma_id}/{modalitat_id}",
 *     tags={"Modalitats Idiomes"},
 *     summary="Obté una associació entre modalitats i idiomes específics",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la modalitat",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació trobada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="modalitat_idioma", type="object", ref="#/components/schemas/Modalitats Idiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
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
    public function show($idioma_id, $modalitat_id)
    {
        try {
            $modalitatidioma = ModalitatsIdiomes::where('idioma_id', $idioma_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$modalitatidioma) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }
            return response()->json(['modalitat_idioma' => $modalitatidioma], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Put(
 *     path="/api/modalitats-idiomes/{idioma_id}/{modalitat_id}",
 *     tags={"Modalitats Idiomes"},
 *     summary="Actualitza una associació entre modalitats i idiomes específics",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la modalitat",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'associació a actualitzar",
 *         @OA\JsonContent(
 *             @OA\Property(property="traduccio", type="string", example="Nova traducció de la modalitat"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació actualitzada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="modalitat_idioma", type="object", ref="#/components/schemas/Modalitats Idiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object", example={
 *                 "traduccio": {"El camp traduccio ha de ser una cadena de text."},
 *             })
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
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
    public function update(Request $request, $idioma_id, $modalitat_id)
    {
        try {
            $reglesValidacio = [
                'traduccio' => 'nullable|string',
                'data_baixa' => 'nullable|date',
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio);
            if ($validacio->fails()) {
                return response()->json(['errors' => $validacio->errors()], 400);
            }

            $modalitatidioma = ModalitatsIdiomes::where('idioma_id', $idioma_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$modalitatidioma) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }

            $modalitatidioma->update($request->all());
            return response()->json(['modalitat_idioma' => $modalitatidioma], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

   /**
 * @OA\Delete(
 *     path="/api/modalitats-idiomes/{idioma_id}/{modalitat_id}",
 *     tags={"Modalitats Idiomes"},
 *     summary="Elimina una associació entre modalitats i idiomes específics",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de la modalitat",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Associació eliminada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducció no trobada")
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
    public function destroy($idioma_id, $modalitat_id)
    {
        try {
            $modalitatidioma = ModalitatsIdiomes::where('idioma_id', $idioma_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$modalitatidioma) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }

            $modalitatidioma->delete();
            return response()->json(['message' => 'Traducció eliminada correctament'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}