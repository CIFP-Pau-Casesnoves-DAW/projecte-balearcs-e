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
     *     path="/api/modalitatsidiomes/{id}",
     *     tags={"ModalitatsIdiomes"},
     *     summary="Elimina una modalitat-idioma específica",
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
     *         description="Modalitat-idioma eliminada correctament"
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
