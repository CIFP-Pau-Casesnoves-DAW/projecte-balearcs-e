<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModalitatsIdiomes;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="ModalitatsIdiomes",
 *     description="Operacions per a les modalitats d'idiomes"
 * )
 */

class ModalitatsIdiomesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/modalitatsidiomes",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Llista totes les modalitats d'idiomes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de modalitats d'idiomes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ModalitatsIdiomes")
     *         )
     *     )
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
     *     path="/api/modalitatsidiomes",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Crea una nova modalitat-idioma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma creada correctament"
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
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Mostra una modalitat-idioma específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna la modalitat-idioma especificada",
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     )
     * )
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
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Actualitza una modalitat-idioma específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ModalitatsIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $idioma_id, $modalitat_id)
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
     *     path="/api/espais-idiomes/{idioma_id}/{modalitat_id}",
     *     tags={"modalitatIdioma"},
     *     summary="Elimina la traducció d'un espai específic",
     *     @OA\Parameter(
     *         name="idioma_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="modalitat_id",
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
