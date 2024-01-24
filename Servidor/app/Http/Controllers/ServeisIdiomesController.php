<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServeisIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="ServeisIdiomes",
 *     description="Operacions per a Serveis Idiomes"
 * )
 */
class ServeisIdiomesController extends Controller
{
    /**
 * @OA\Get(
 *     path="/serveisIdiomes",
 *     summary="Obté una llista de tots els serveis i idiomes",
 *     tags={"ServeisIdiomes"},
 *     @OA\Response(
 *         response=200,
 *         description="Operació exitosa",
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
 *                 @OA\Items(ref="#/components/schemas/ServeisIdiomes")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ServeisIdiomes",
 *     type="object",
 *     @OA\Property(property="id", type="integer", format="int64", description="Identificador únic del servei o idioma"),
 *     @OA\Property(property="idioma_id", type="integer", format="int64", description="Identificador únic de l'idioma"),
 *     @OA\Property(property="servei_id", type="integer", format="int64", description="Identificador únic del servei"),
 *     @OA\Property(property="traduccio", type="string", description="Traducció del servei en l'idioma"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true, description="Data de baixa del servei en l'idioma")
 * )
 * 
 */
    public function index()
    {
        try {
            $tuples = ServeisIdiomes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

 
    /**
 * @OA\Post(
 *     path="/serveisidiomes",
 *     summary="Crea un nou servei idioma",
 *     description="Afegeix un nou servei idioma a la base de dades",
 *     operationId="storeServeiIdioma",
 *     tags={"serveisidiomes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou servei idioma",
 *         @OA\JsonContent(
 *              required={"idioma_id", "servei_id", "traduccio"},
 *              @OA\Property(property="idioma_id", type="integer", format="int64", example="1"),
 *              @OA\Property(property="servei_id", type="integer", format="int64", example="1"),
 *              @OA\Property(property="traduccio", type="string", example="Traducció de prova")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei idioma creat amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
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
 *     ),
 * )
 */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'idioma_id' => 'required|int',
                'servei_id' => 'required|int',
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

            $tupla = ServeisIdiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }


    /**
 * @OA\Get(
 *     path="/serveisIdiomes/{idioma_id}/{servei_id}",
 *     summary="Obté una traducció específica",
 *     description="Retorna una traducció basada en l'ID de l'idioma i del servei",
 *     operationId="showServeiIdioma",
 *     tags={"Serveis Idiomes"},
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
 *         name="servei_id",
 *         in="path",
 *         description="ID del servei",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció trobada amb èxit",
 *         @OA\JsonContent(ref="#/components/schemas/ServeiIdioma")
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
    public function show($idioma_id, $servei_id)
    {
        try {
            $serveiIdioma = ServeisIdiomes::where('idioma_id', $idioma_id)->where('servei_id', $servei_id)->first();
            if (!$serveiIdioma) {
                return response()->json(['message' => 'Traducció no trobada'], 404);
            }
            return response()->json(['servei_idioma' => $serveiIdioma], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }



    /**
 * @OA\Put(
 *     path="/serveis/{idioma_id}/{servei_id}",
 *     tags={"Serveis"},
 *     summary="Actualitza una traducció de servei",
 *     description="Actualitza la traducció d'un servei específic basant-se en l'ID d'idioma i l'ID de servei.",
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de la traducció a actualitzar",
 *         @OA\JsonContent(
 *             required={"traduccio"},
 *             @OA\Property(
 *                 property="traduccio",
 *                 type="string",
 *                 description="Text de la traducció del servei"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció actualitzada amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="modalitat_idioma",
 *                 description="Informació de la traducció actualitzada",
 *                 type="object"
 *             )
 *         )
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
 */
    //funciona
    public function update(Request $request, $idioma_id, $servei_id)
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
                $traduccio_servei = ServeisIdiomes::where('idioma_id', $idioma_id)->where('servei_id', $servei_id);
                if (!empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => now()]);
                } else if (empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => NULL]);
                }

                $traduccio_servei->update($request->all());
                return response()->json(['modalitat_idioma' => $traduccio_servei], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La traduccio del servei amb la id ' . $servei_id . 'amb idioma' . $idioma_id . 'no existeix'
                ], 404);
            }
        }
    }


    /**
 * @OA\Delete(
 *     path="/serveis/{idioma_id}/{servei_id}",
 *     summary="Esborra una traducció específica de servei",
 *     description="Esborra la traducció d'un servei basada en l'ID de l'idioma i el servei",
 *     operationId="destroyTraduccioServei",
 *     tags={"Traduccions"},
 *     @OA\Parameter(
 *         name="idioma_id",
 *         in="path",
 *         description="ID de l'idioma de la traducció a esborrar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         description="ID del servei de la traducció a esborrar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
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
 *         description="Error intern del servidor"
 *     )
 * )
 */
    //funciona
    public function destroy($idioma_id, $servei_id)
    {
        try {
            $traduccio_servei = ServeisIdiomes::where('idioma_id', $idioma_id)->where('servei_id', $servei_id);
            $traduccio_servei->delete();

            if ($traduccio_servei) {
                return response()->json(['status' => ' Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'No trobat'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}