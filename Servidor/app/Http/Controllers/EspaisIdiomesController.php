<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiIdioma",
 *     description="Operacions per a Traduccions d'Espais en Diferents Idiomes"
 * )
 */
class EspaisIdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais-idiomes",
     *     tags={"EspaiIdioma"},
     *     summary="Llista totes les traduccions d'espais",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les traduccions d'espais",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaiIdioma")
     *         )
     *     )
     * )
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
     *     path="/api/espais-idiomes",
     *     tags={"EspaiIdioma"},
     *     summary="Crea una nova traducció per un espai",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idioma_id", "espai_id", "traduccio"},
     *             @OA\Property(property="idioma_id", type="integer", example=1),
     *             @OA\Property(property="espai_id", type="integer", example=1),
     *             @OA\Property(property="traduccio", type="string", example="Descripció de l'espai en un idioma específic"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció creada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
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
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"EspaiIdioma"},
     *     summary="Mostra una traducció específica d'un espai",
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
     *         description="Retorna la traducció específica",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
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
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"EspaiIdioma"},
     *     summary="Actualitza la traducció d'un espai específic",
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="traduccio", type="string", example="Nova descripció de l'espai en un idioma específic"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció actualitzada correctament",
     *         @OA\JsonContent(ref="#/components/schemas/EspaiIdioma")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
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
     *     path="/api/espais-idiomes/{idioma_id}/{espai_id}",
     *     tags={"espaiIdioma"},
     *     summary="Elimina la traducció d'un espai específic",
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
     *         description="Traducció eliminada correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció eliminada correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Traducció no trobada")
     *         )
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
