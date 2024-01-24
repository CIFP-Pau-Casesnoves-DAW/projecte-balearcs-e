<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisServeis;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaisServeis",
 *     description="Operacions per a Serveis d'Espais"
 * )
 */
class EspaisServeisController extends Controller
{
   /**
 * @OA\Get(
 *     path="/espaisserveis",
 *     summary="Obté llista de tots els espais serveis",
 *     tags={"EspaisServeis"},
 *     @OA\Response(
 *         response=200,
 *         description="Operació realitzada correctament.",
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
 *                 @OA\Items(ref="#/components/schemas/EspaisServeis")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 additionalProperties={
 *                     "type": "array",
 *                     "items": {"type": "string"}
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string"
 *             )
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *    schema="EspaisServeis",
 *    type="object",
 *        @OA\Property(property="servei_id", type="integer", example=1),
 *        @OA\Property(property="espai_id", type="integer", example=1),
 *        @OA\Property(property="data_baixa", type="date", example="2021-03-01"),
 *        
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
 *     path="/espaisserveis",
 *     summary="Crea un nou servei associat a un espai",
 *     tags={"EspaisServeis"},
 *     @OA\RequestBody(
 *         description="Dades necessàries per crear un nou servei per un espai",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"servei_id", "espai_id"},
 *             @OA\Property(property="servei_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei creat amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/EspaisServeis"
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
 *     ),
 *     
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
 *     path="/espaisserveis/{espai_id}/{servei_id}",
 *     summary="Obté un servei específic d'un espai donat",
 *     tags={"EspaisServeis"},
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
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
 *     @OA\Response(
 *         response=200,
 *         description="Servei trobat amb èxit",
 *         @OA\JsonContent(ref="#/components/schemas/EspaisServeis")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Servei no trobat"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor"
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
 *     path="/espaisserveis/{espai_id}/{servei_id}",
 *     summary="Actualitza un servei d'un espai específic",
 *     tags={"EspaisServeis"},
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="servei_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei actualitzat amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="servei_idioma", type="object", ref="#/components/schemas/EspaisServeis")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No trobat"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
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
 *     path="/espaisserveis/{espai_id}/{servei_id}",
 *     summary="Elimina un servei d'un espai",
 *     tags={"EspaisServeis"},
 *     @OA\Parameter(
 *         name="espai_id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="servei_id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei eliminat correctament"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No trobat"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error del servidor"
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
