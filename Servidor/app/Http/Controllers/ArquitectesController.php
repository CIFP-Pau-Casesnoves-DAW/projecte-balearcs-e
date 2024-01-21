<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquitectes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Tag(
 *     name="Arquitecte",
 *     description="Operacions per a Arquitectes"
 * )
 */
class ArquitectesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/arquitectes",
     *      operationId="getArquitectes",
     *      tags={"Arquitectes"},
     *      summary="Obtenir tots els arquitectes",
     *      description="Retorna una llista de tots els arquitectes",
     *      @OA\Response(
     *          response=200,
     *          description="Llista d'arquitectes",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Arquitecte")
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Error de validació",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="data", type="object", example={"field_name": {"Error message"}})
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error intern del servidor",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Missatge d'error intern del servidor")
     *          )
     *      )
     * )
     * @OA\Schema(
     * schema="Arquitecte",
     *     type="object",
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="data_baixa", type="string", format="date"),
     * )
     * 
     */
    public function index()
    {
        try {
            $tuples = Arquitectes::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/arquitectes",
 *     summary="Crea un nou arquitecte",
 *     tags={"Arquitectes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou arquitecte",
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Antoni Gaudí"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-12-31", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
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
            'nom' => 'required|string|max:255',
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

        $tupla = Arquitectes::create($request->all());

        return response()->json(['status' => 'success', 'data' => $tupla], 200);
    } catch (\Illuminate\Validation\ValidationException $validationException) {
        return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
    } catch (\Exception $exception) {
        return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
    }
}

/**
 * @OA\Get(
 *     path="/arquitectes/{id}",
 *     summary="Obté les dades d'un arquitecte",
 *     tags={"Arquitectes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'arquitecte",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Usuari no trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
public function show($id)
{
    try {
        $tupla = Arquitectes::findOrFail($id);
        return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['status' => 'Usuaris no trobat'], 400);
    } catch (\Exception $exception) {
        return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
    }
}

 /**
 * @OA\Put(
 *     path="/arquitectes/{id}",
 *     summary="Actualitza les dades d'un arquitecte",
 *     tags={"Arquitectes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'arquitecte a actualitzar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'arquitecte a actualitzar",
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="nom", type="string", example="Antoni Gaudí", maxLength=255),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-12-31", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'arquitecte actualitzades correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */


 public function update(Request $request, $id)
 {
     try {
         $tupla = Arquitectes::findOrFail($id);
         $reglesValidacio = [
             'nom' => 'nullable|string|max:255',
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

         $tupla->update($request->all());

         return response()->json(['status' => 'success', 'data' => $tupla], 200);
     } catch (\Illuminate\Validation\ValidationException $validationException) {
         return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
     } catch (\Exception $exception) {
         return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
     }
 }
    

/**
 * @OA\Delete(
 *     path="/arquitectes/{id}",
 *     summary="Elimina un arquitecte",
 *     tags={"Arquitectes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Identificador únic de l'arquitecte a eliminar",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
public function destroy($id)
{
    try {
        $tupla = Arquitectes::findOrFail($id);
        $tupla->delete();
        return response()->json(['status' => 'success', 'data' => $tupla], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['status' => 'Error'], 400);
    } catch (\Exception $exception) {
        return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
    }
}
}