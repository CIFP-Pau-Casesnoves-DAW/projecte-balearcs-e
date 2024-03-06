<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitesIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="VisitesIdiomes",
 *     description="Operacions per a Visites Idiomes"
 * )
 */
class VisitesIdiomesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/visitesidiomes",
     *     tags={"VisitesIdiomes"},
     *     summary="Llista totes les entitats VisitesIdiomes",
     *     description="Recupera una llista de totes les entitats VisitesIdiomes des del servidor.",
     *     @OA\Response(
     *         response=200,
     *         description="Llista d'entitats VisitesIdiomes recuperada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/VisitesIdiomes")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació en la sol·licitud",
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
     *     schema="VisitesIdiomes",
     *     type="object",
     *     description="Model de l'entitat VisitesIdiomes",
     *     @OA\Property(property="id", type="integer", description="Identificador únic de la visita idioma"),
     *     @OA\Property(property="visita_id", type="integer", description="Identificador de la visita"),
     *     @OA\Property(property="idioma_id", type="integer", description="Identificador de l'idioma"),
     *     @OA\Property(property="descripcio", type="string", description="Descripció de la visita en l'idioma especificat"),
     *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true, description="Data de baixa de la visita idioma")
     * )
     */

    public function index()
    {
        try {
            $tuples = VisitesIdiomes::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/visitesidiomes",
     *     tags={"VisitesIdiomes"},
     *     summary="Crea una nova entitat VisitesIdiomes",
     *     description="Guarda una nova entitat VisitesIdiomes a la base de dades segons les dades proporcionades.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a la creació de VisitesIdiomes",
     *         @OA\JsonContent(
     *             required={"idioma_id", "visita_id", "traduccio"},
     *             @OA\Property(property="idioma_id", type="integer", example=1),
     *             @OA\Property(property="visita_id", type="integer", example=2),
     *             @OA\Property(property="traduccio", type="string", example="Traducció en un idioma específic"),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-24")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Entitat VisitesIdiomes creada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/VisitesIdiomes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació en les dades enviades",
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
     * 
     */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'idioma_id' => 'required|int|exists:idiomes,id',
                'visita_id' => 'required|int|exists:visites,id',
                'traduccio' => 'required|string|max:255',
                'data_baixa' => 'nullable|date',
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

            $tupla = VisitesIdiomes::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/visitesidiomes/{idioma_id}/{visita_id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Mostra la traducció d'una visita específica en un idioma concret",
     *     description="Retorna les dades de la traducció d'una visita en un idioma específic segons l'identificador de l'idioma i de la visita.",
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
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         description="Identificador de la visita",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció trobada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="visita_idioma", ref="#/components/schemas/VisitesIdiomes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="string", example="Traducció no trobada")
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
    public function show($idioma_id, $visita_id)
    {
        try {
            $visitaIdioma = VisitesIdiomes::where('idioma_id', $idioma_id)->where('visita_id', $visita_id)->first();
            if (!$visitaIdioma) {
                return response()->json(['status' => 'error', 'data' => 'Traducció no trobada'], 404);
            }
            return response()->json(['status' => 'success', 'data' => $visitaIdioma], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }




    /**
     * @OA\Put(
     *     path="/api/visitesidiomes/{idioma_id}/{visita_id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Actualitza la traducció d'una visita existent",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'idioma de la traducció",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de la visita a actualitzar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades de la traducció de la visita a actualitzar",
     *         @OA\JsonContent(
     *             required={"traduccio"},
     *             @OA\Property(property="traduccio", type="string", description="Text de la traducció", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades de la traducció actualitzades correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/VisitesIdiomes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validació de dades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="errors", type="object", additionalProperties={"type":"string"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traducció no trobada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="string")
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
    public function update(Request $request, $idioma_id, $visita_id)
    {
        $reglesValidacio = [
            'traduccio' => 'filled|string|max:255',
        ];
        $missatges = [
            'filled' => 'El camp :attribute no pot estar buit',
            'exists' => ':attribute ha de existir',
            'required' => 'El camp :attribute és obligatori.',
            'max' => 'El :attribute ha de tenir màxim :max caràcters.'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if ($validacio->fails()) {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        } else {
            try {
                $traduccio_visita = VisitesIdiomes::where('idioma_id', $idioma_id)->where('visita_id', $visita_id);
                if (!empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => now()]);
                } else if (empty($request->data_baixa)) {
                    $request->merge(['data_baixa' => NULL]);
                }

                $traduccio_visita->update($request->all());
                return response()->json(['status' => 'success', 'data' => $traduccio_visita], 200);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'data' => 'La traduccio de la visita amb la id ' . $visita_id . 'amb idioma' . $idioma_id . 'no existeix'], 404);
            }
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/visitesidiomes/{idioma_id}/{visita_id}",
     *     tags={"VisitesIdiomes"},
     *     summary="Esborra una traducció específica d'una visita",
     *     description="Esborra la traducció d'una visita basant-se en l'idioma i l'identificador de la visita",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         description="Identificador de l'idioma de la traducció a esborrar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="visita_id",
     *         in="path",
     *         required=true,
     *         description="Identificador de la visita de la traducció a esborrar",
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
    public function destroy($idioma_id, $visita_id)
    {
        try {
            $traduccio_visita = VisitesIdiomes::where('idioma_id', $idioma_id)->where('visita_id', $visita_id);
            $traduccio_visita->delete();

            if ($traduccio_visita) {
                return response()->json(['status' => 'success', 'data' => 'Esborrat correctament'], 200);
            } else {
                return response()->json(['status' => 'error', 'data' => 'No trobat'], 404);
            }
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
