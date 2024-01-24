<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisModalitats;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiModalitat",
 *     description="Operacions per a Modalitats d'Espais"
 * )
 */
class EspaisModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/EspaisModalitats",
     *     tags={"EspaisModalitats"},
     *     summary="Llista totes les modalitats d'idiomes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de modalitats d'idiomes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaisModalitats")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = EspaisModalitats::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/EspaisModalitats",
     *     tags={"EspaisModalitats"},
     *     summary="Crea una nova modalitat-idioma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
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
                'modalitat_id' => 'required|int',
                'espai_id' => 'required|int',
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

            $tupla = EspaisModalitats::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/EspaisModalitats/{id}",
     *     tags={"EspaisModalitats"},
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
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
     *     )
     * )
     */
    public function show($espai_id, $modalitat_id)
    {
        try {
            $espaimodalitat = EspaisModalitats::where('espai_id', $espai_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$espaimodalitat) {
                return response()->json(['message' => 'No trobat'], 404);
            }
            return response()->json(['modalitat_idioma' => $espaimodalitat], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/EspaisModalitats/{id}",
     *     tags={"EspaisModalitats"},
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
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $espai_id, $modalitat_id)
    {
        try {
            $reglesValidacio = [
                'modalitat_id' => 'nullable|int',
                'espai_id' => 'nullable|int',
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio);
            if ($validacio->fails()) {
                return response()->json(['errors' => $validacio->errors()], 400);
            }

            $espaimodalitat = EspaisModalitats::where('espai_id', $espai_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$espaimodalitat) {
                return response()->json(['message' => 'No trobat'], 404);
            }

            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
            }

            $espaimodalitat->update($request->all());
            return response()->json(['modalitat_idioma' => $espaimodalitat], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/EspaisModalitats/{id}",
     *     tags={"EspaisModalitats"},
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
    public function destroy($espai_id, $modalitat_id)
    {
        try {
            $espaimodalitat = EspaisModalitats::where('espai_id', $espai_id)->where('modalitat_id', $modalitat_id)->first();
            if (!$espaimodalitat) {
                return response()->json(['message' => 'No trobat'], 404);
            }

            $espaimodalitat->delete();
            return response()->json(['message' => 'Eliminat correctament'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
