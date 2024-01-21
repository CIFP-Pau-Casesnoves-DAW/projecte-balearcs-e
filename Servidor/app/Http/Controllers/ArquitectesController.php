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
     *     path="/api/arquitectes",
     *     tags={"Arquitectes"},
     *     summary="Llista tots els arquitectes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els arquitectes",
     *         @OA\JsonContent(
     *             type="array",
     *            @OA\Items(ref="#/components/schemas/Arquitecte")
     *        )
     *    )
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
        $arquitectes = Arquitectes::all();
        return response()->json(['status' => 'correcte', 'data' => $arquitectes], 200);
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
 *             @OA\Property(property="nom", type="string", example="Joan Miró"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcte"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {
       
        $reglesValidacio = [
            'nom' => 'required|string|max:255',  // El nom és obligatori, ha de ser una cadena de text i no més de 255 caràcters.
            'data_baixa' => 'nullable|date',     // La data de baixa és opcional i ha de ser una data vàlida si s'especifica.
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if (!$validacio->fails()) {
            $arquitecte = Arquitectes::create($request->all());
            return response()->json(['status' => 'correcte', 'data' => $arquitecte], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }
    }

    /**
 * @OA\Get(
 *     path="/arquitectes/{id}",
 *     summary="Obté un arquitecte per ID",
 *     tags={"Arquitectes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'arquitecte",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte trobat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcte"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Arquitecte no trobat")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $arquitecte = Arquitectes::findOrFail($id);
            return response()->json(['status' => 'correcte', 'data' => $arquitecte], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Arquitecte no trobat'], 404);
        }
    }

   /**
 * @OA\Put(
 *     path="/arquitectes/{id}",
 *     summary="Actualitza un arquitecte existent",
 *     tags={"Arquitectes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'arquitecte a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per actualitzar l'arquitecte",
 *         @OA\JsonContent(
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Antoni Gaudí"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte actualitzat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Arquitecte")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Arquitecte no trobat")
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
        $arquitecte = Arquitectes::findOrFail($id);
        $arquitecte->update($request->all());
    
        return response()->json(['status' => 'success', 'data' => $arquitecte], 200);
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
 *         description="ID de l'arquitecte a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Arquitecte eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Arquitecte eliminat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Arquitecte no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Arquitecte no trobat")
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
        $arquitecte = Arquitectes::findOrFail($id);
        $arquitecte->delete();
        return response()->json(['status' => 'success', 'message' => 'Arquitecte eliminat correctament'], 200);
    }

}