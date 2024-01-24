<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisServeis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaiServei",
 *     description="Operacions per a Serveis d'Espais"
 * )
 */
class EspaisServeisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/EspaisServeis",
     *     tags={"EspaisServeis"},
     *     summary="Llista totes les modalitats d'idiomes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de modalitats d'idiomes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaisServeis")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = EspaisServeis::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/EspaisServeis",
     *     tags={"EspaisServeis"},
     *     summary="Crea una nova modalitat-idioma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/EspaisServeis")
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
                'servei_id' => 'required|int',
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

            $tupla = EspaisServeis::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/EspaisServeis/{id}",
     *     tags={"EspaisServeis"},
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
     *         @OA\JsonContent(ref="#/components/schemas/EspaisServeis")
     *     )
     * )
     */
    public function show($espai_id, $servei_id)
    {
        try {
            $espaisservei = EspaisServeis::where('espai_id', $espai_id)->where('servei_id', $servei_id)->first();
            if (!$espaisservei) {
                return response()->json(['message' => 'No trobat'], 404);
            }
            return response()->json(['servei_idioma' => $espaisservei], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/EspaisServeis/{id}",
     *     tags={"EspaisServeis"},
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
     *         @OA\JsonContent(ref="#/components/schemas/EspaisServeis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat-idioma actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, $espai_id, $servei_id)
    {
        try {
            $reglesValidacio = [
                'servei_id' => 'nullable|int',
                'espai_id' => 'nullable|int',
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio);
            if ($validacio->fails()) {
                return response()->json(['errors' => $validacio->errors()], 400);
            }

            $espaisservei = EspaisServeis::where('espai_id', $espai_id)->where('servei_id', $servei_id)->first();
            if (!$espaisservei) {
                return response()->json(['message' => 'No trobat'], 404);
            }

            $espaisservei->update($request->all());
            return response()->json(['servei_idioma' => $espaisservei], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/EspaisServeis/{id}",
     *     tags={"EspaisServeis"},
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
    public function destroy($espai_id, $servei_id)
    {
        try {
            $espaisservei = EspaisServeis::where('espai_id', $espai_id)->where('servei_id', $servei_id)->first();
            if (!$espaisservei) {
                return response()->json(['message' => 'No trobat'], 404);
            }

            $espaisservei->delete();
            return response()->json(['message' => 'Eliminat correctament'], 200);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
