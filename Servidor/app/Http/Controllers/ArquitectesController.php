<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arquitecte;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Arquitecte",
 *     description="Operacions per a Arquitectes"
 * )
 */
class ArquitecteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/arquitectes",
     *     tags={"Arquitecte"},
     *     summary="Llista tots els arquitectes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els arquitectes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Arquitecte")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $arquitectes = Arquitecte::all();
        return response()->json(['status' => 'correcte', 'data' => $arquitectes], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/arquitectes",
     *     tags={"Arquitecte"},
     *     summary="Crea un nou arquitecte",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Arquitecte")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Arquitecte creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
       
        $validacio = Validator::make($request->all(), $reglesValidacio);
        if (!$validacio->fails()) {
            $arquitecte = Arquitecte::create($request->all());
            return response()->json(['status' => 'correcte', 'data' => $arquitecte], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }
    }

    // Mètodes show, update, i destroy amb la lògica corresponent per a arquitectes
    /**
     * @OA\Get(
     *     path="/api/arquitectes/{id}",
     *     tags={"Arquitecte"},
     *     summary="Mostra un arquitecte específic",
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
     *         description="Retorna l'arquitecte especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Arquitecte")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $arquitecte = Arquitecte::findOrFail($id);
            return response()->json(['status' => 'correcte', 'data' => $arquitecte], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Arquitecte no trobat'], 404);
        }
    }

    /**
 * @OA\Put(
 *     path="/api/arquitectes/{id}",
 *     tags={"Arquitecte"},
 *     summary="Actualitza un arquitecte específic",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'arquitecte a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar un arquitecte",
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Joan"),
 *             // Afegiu altres propietats aquí segons el model Arquitecte
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte actualitzat correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
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
 *         response=404,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Arquitecte no trobat")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        // Defineix les regles de validació
        $reglesValidacio = [
            'nom' => 'required|string|max:255',
        ];
    
        // Realitza la validació
        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validacio->errors()], 400);
        }
    
        // Troba i actualitza l'arquitecte
        $arquitecte = Arquitecte::findOrFail($id);
        $arquitecte->update($request->all());
    
        return response()->json(['status' => 'success', 'data' => $arquitecte], 200);
    }
    

    /**
     * @OA\Delete(
     *     path="/api/arquitectes/{id}",
     *     tags={"Arquitecte"},
     *     summary="Elimina un arquitecte específic",
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
     *         description="Arquitecte eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        $arquitecte = Arquitecte::findOrFail($id);
        $arquitecte->delete();
        return response()->json(['status' => 'success', 'message' => 'Arquitecte eliminat correctament'], 200);
    }

}
