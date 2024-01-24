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
 *     path="/modalitatsidiomes",
 *     summary="Crea una nova traducció de modalitat per a un idioma específic",
 *     tags={"ModalitatsIdiomes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear una nova traducció de modalitat",
 *         @OA\JsonContent(
 *             required={"idioma_id", "modalitat_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example=1, description="Identificador de l'idioma"),
 *             @OA\Property(property="modalitat_id", type="integer", example=1, description="Identificador de la modalitat"),
 *             @OA\Property(property="traduccio", type="string", example="Traducció de la modalitat", description="La traducció de la modalitat en l'idioma especificat"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció creada amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/ModalitatsIdiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", description="Detalls de l'error de validació")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", description="Missatge d'error del servidor")
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'idioma_id' => 'required|int',
                'modalitat_id' => 'required|int',
                'traduccio' => 'required|string|max:255',
                
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
 *     path="/modalitatsIdiomes/{idioma_id}/{modalitat_id}",
 *     operationId="updateTraduccioModalitat",
 *     tags={"Traduccions de Modalitats per Idioma"},
 *     summary="Actualitza una traducció específica de modalitat per un idioma donat",
 *     description="Actualitza la informació de la traducció de modalitat segons els identificadors d'idioma i modalitat. Permet actualitzar els camps de la traducció.",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         description="ID de l'idioma",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         description="ID de la modalitat",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             ref="#/components/schemas/ModalitatIdiomaUpdateRequest"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció actualitzada amb èxit",
 *         @OA\JsonContent(ref="#/components/schemas/ModalitatIdioma")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
 *     )
 * )
 *
 */
    public function update(Request $request, $idioma_id, $modalitat_id)
    {
        if (!empty($request->data_baixa)) {
            $request->merge(['data_baixa' => now()]);
        } else if (empty($request->data_baixa)) {
            $request->merge(['data_baixa' => NULL]);
        }
        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $traduccio_modalitat = ModalitatsIdiomes::where('idioma_id', $idioma_id)->where('modalitat_id', $modalitat_id);
                if (!empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => now()]);
                } else if (empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => NULL]);
                }
                $traduccio_modalitat->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_modalitat
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del modalitat amb la id ' . $modalitat_id . 'amb idioma' . $idioma_id . 'no existeix'
                ], 404);
            }
        }
    }

/**
 * @OA\Delete(
 *     path="/api/modalitats-idiomes/{idioma_id}/{modalitat_id}",
 *     summary="Esborra una traducció de modalitat per un idioma específic",
 *     description="Esborra la traducció de la modalitat per l'ID d'idioma i ID de modalitat especificats. Retorna un missatge de confirmació o d'error en cas que no es trobi.",
 *     tags={"Modalitats Idiomes"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         description="ID de l'idioma associat a la traducció de la modalitat",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="modalitat_id",
 *         in="path",
 *         description="ID de la modalitat associada a la traducció",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Esborrat correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="Esborrat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No trobat",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="No trobat")
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
    public function destroy($idioma_id, $modalitat_id)
    {
        try {
            $traduccio_modalitat = ModalitatsIdiomes::where('idioma_id', $idioma_id)->where('modalitat_id', $modalitat_id);
            $traduccio_modalitat->delete();
            if ($traduccio_modalitat) {
                return response()->json(['status' => ' Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'No trobat'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}