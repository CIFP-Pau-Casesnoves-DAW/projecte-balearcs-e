<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EspaisModalitats;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="EspaisModalitats",
 *     description="Operacions per a Modalitats d'Espais"
 * )
 */
class EspaisModalitatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/espaismodalitats",
     *     tags={"EspaisModalitats"},
     *     summary="Llista totes les modalitats dels espais",
     *     @OA\Response(
     *         response=200,
     *         description="Operació reeixida",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EspaisModalitats")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al servidor"
     *     )
     * )
     * 
     * @OA\Schema(
     *    schema="EspaisModalitats",
     *    description="Model de les modalitats dels espais",
     *    @OA\Property( property="espai_id", type="integer", description="Clau primària de l'espai" ),
     *    @OA\Property( property="modalitat_id", type="integer", description="Clau primària de la modalitat" ),
     *    @OA\Property( property="data_baixa", type="date", description="Data de baixa de la modalitat" ),
     * )
     *    
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
     *     path="/espais-modalitats",
     *     tags={"EspaisModalitats"},
     *     summary="Crea una nova associació entre un espai i una modalitat",
     *     operationId="storeEspaiModalitat",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a la creació de l'associació",
     *         @OA\JsonContent(
     *             required={"modalitat_id", "espai_id"},
     *             @OA\Property(property="modalitat_id", type="integer", example=1, description="ID de la modalitat"),
     *             @OA\Property(property="espai_id", type="integer", example=2, description="ID de l'espai")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Associació creada amb èxit",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/EspaisModalitats")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="errors", type="object")
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
     *     path="/espaismodalitats/{espai_id}/{modalitat_id}",
     *     tags={"EspaisModalitats"},
     *     summary="Mostra una modalitat d'espai específica",
     *     @OA\Parameter(
     *         name="espai_id",
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
     *         description="Operació reeixida",
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No trobat"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al servidor"
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
     *     path="/espaismodalitats/{espai_id}/{modalitat_id}",
     *     tags={"EspaisModalitats"},
     *     summary="Actualitza una modalitat d'un espai",
     *     operationId="updateEspaiModalitat",
     *     description="Actualitza les dades d'una modalitat específica d'un espai arquitectònic. Requereix l'ID de l'espai i de la modalitat.",
     *     @OA\Parameter(
     *         name="espai_id",
     *         in="path",
     *         required=true,
     *         description="ID de l'espai arquitectònic",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="modalitat_id",
     *         in="path",
     *         required=true,
     *         description="ID de la modalitat",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades de la modalitat per actualitzar",
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modalitat d'espai actualitzada amb èxit",
     *         @OA\JsonContent(ref="#/components/schemas/EspaisModalitats")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Sol·licitud incorrecta"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Modalitat no trobada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
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
     *     path="/api/espaismodalitats/{espai_id}/{modalitat_id}",
     *     summary="Elimina una entitat EspaiModalitat",
     *     description="Elimina l'entitat EspaiModalitat basant-se en l'ID d'espai i l'ID de modalitat proporcionats.",
     *     operationId="destroyEspaiModalitat",
     *     tags={"EspaisModalitats"},
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
     *         name="modalitat_id",
     *         in="path",
     *         required=true,
     *         description="ID de la modalitat",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="EspaiModalitat eliminat correctament",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="Eliminat correctament")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No trobat",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="No trobat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor",
     *         @OA\JsonContent(
     *            @OA\Property(property="status", type="string", example="error"),
     *            @OA\Property(property="message", type="string", example="Missatge d'error")
     *         )
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
