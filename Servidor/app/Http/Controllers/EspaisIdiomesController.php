<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *    name="EspaisIdiomes",
 *   description="API Endpoints of EspaisIdiomes Controller"
 * )
 * 
 */
class EspaisIdiomesController extends Controller
{
/**
 * @OA\Get(
 *     path="/espaisidiomes",
 *     tags={"EspaisIdiomes"},
 *     summary="Obté tots els espais i idiomes",
 *     description="Retorna una llista de tots els espais i idiomes disponibles.",
 *     @OA\Response(
 *         response=200,
 *         description="Operació reeixida",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="correcto"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/EspaisIdiomes")
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
 * 
 * @OA\Schema(
 *  schema="EspaisIdiomes",
 *  title="EspaisIdiomes",
 *  description="Model d'EspaisIdiomes",
 *      @OA\Property(property="idioma_id", type="integer", description="Id de l'idioma"), 
 *      @OA\Property(property="espai_id", type="integer", description="Id de l'espai"),
 *      @OA\Property(property="traduccio", type="string", description="Traducció de l'espai"),
 *      @OA\Property(property="data_baixa", type="date", description="Data de baixa de l'espai"),
 * )
 * 
 */
    public function index()
    {
        try {
            $tuples = EspaisIdiomes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

   /**
 * @OA\Post(
 *     path="/espais-idiomes",
 *     summary="Crea una nova traducció d'espai",
 *     tags={"Espais Idiomes"},
 *     @OA\RequestBody(
 *         description="Dades necessàries per a crear una nova traducció d'espai",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"idioma_id", "espai_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", format="int64", example=1),
 *             @OA\Property(property="espai_id", type="integer", format="int64", example=1),
 *             @OA\Property(property="traduccio", type="string", example="Descripció de l'espai en un idioma específic"),
 *             @OA\Property(property="data_baixa", type="string", format="date-time", example="2024-01-24T15:00:00.000Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció creada amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/EspaisIdiomes"
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
                'espai_id' => 'required|int',
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

            $tupla = EspaisIdiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/espaisidiomes/{idioma_id}/{espai_id}",
 *     summary="Obté la traducció específica d'un espai",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operació exitosa",
 *         @OA\JsonContent(ref="#/components/schemas/EspaisIdiomes")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor"
 *     )
 * )
 */
    public function show($idioma_id, $espai_id)
    {
        try {
            $espaiIdioma = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id)->first();
            if (!$espaiIdioma) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }
            return response()->json(['espai_idioma' => $espaiIdioma], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }


  /**
 * @OA\Put(
 *     path="/espais-idiomes/{idioma_id}/{espai_id}",
 *     summary="Actualitza una traducció d'un espai",
 *     description="Actualitza la traducció d'un espai amb els valors proporcionats",
 *     operationId="updateTraduccioEspai",
 *     tags={"Espais Idiomes"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="Identificador de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="Identificador de l'espai",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Dades de la traducció per actualitzar",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/EspaisIdiomes")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció actualitzada correctament",
 *         @OA\JsonContent(ref="#/components/schemas/EspaisIdiomes")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides proporcionades"
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
 */

    public function update(Request $request, $idioma_id, $espai_id)
    {
        $reglesValidacio = [
            'traduccio' => 'nullable|string|max:255',
        ];
        $missatges = [
            'required' => 'El camp :attribute és obligatori.',
            'max' => 'El :attribute ha de tenir màxim :max caràcters.'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validacio->errors()
            ], 400);
        } else {
            try {
                $traduccio_espai = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id);
                if (!empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => now()]);
                } else if (empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => NULL]);
                }

                $traduccio_espai->update($request->all());
                return response()->json([
                    'status' => 'success',
                    'data' => $traduccio_espai
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del espai amb la id ' . $espai_id . 'amb idioma' . $idioma_id . 'no existeix'
                ], 404);
            }
        }
    }

    /**
 * @OA\Delete(
 *     path="/espaisidiomes/{idioma_id}/{espai_id}",
 *     summary="Esborra la traducció d'un espai",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció esborrada correctament"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció no trobada"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor"
 *     )
 * )
 */
    //funciona
    public function destroy($idioma_id, $espai_id)
    {
        try {
            $traduccio_espai = EspaisIdiomes::where('idioma_id', $idioma_id)->where('espai_id', $espai_id);
            $traduccio_espai->delete();

            if ($traduccio_espai) {
                return response()->json(['status' => ' Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'No trobat'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
