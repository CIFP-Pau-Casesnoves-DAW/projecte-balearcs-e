<?php

namespace App\Http\Controllers;

use App\Models\Comentaris;
use Illuminate\Http\Request;


/** 
 * @OA\Tag(
 *     name="Comentaris"
 * )
 */

class ComentarisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/comentaris",
     *     summary="Llista de comentaris",
     *     tags={"Comentaris"},
     *     @OA\Response(
     *         response=200,
     *         description="Llista de tots els comentaris",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Comentari")
     *         )
     *     )
     * )
     * @OA\Schema(
     *     schema="Comentari",
     *     type="object",
     *     @OA\Property(property="id", type="integer"),
     *     @OA\Property(property="usuari_id", type="integer"),
     *     @OA\Property(property="espai_id", type="integer"),
     *     @OA\Property(property="data", type="string", format="date-time")
     * )
     */
    public function index()
    {
        $tuples = Comentaris::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
 * Emmagatzema un nou comentari a la base de dades.
 * 
 * @OA\Post(
 *     path="/comentaris",
 *     summary="Crea un nou comentari",
 *     tags={"Comentaris"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"usuari_id", "espai_id", "data"},
 *             @OA\Property(property="usuari_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=2),
 *             @OA\Property(property="data", type="string", format="date-time", example="2023-01-01T00:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Comentari creat",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Comentari")
 *         )
 *     )
 * )
 */
        public function store(Request $request)
        {
            // Validació de dades
            $validatedData = $request->validate([
                'usuari_id' => 'required|exists:usuaris,id', 
                'espai_id' => 'required|exists:espais,id',   
                'data' => 'required|date'
            ]);
    
            // Creació del comentari
            $comentari = Comentaris::create($validatedData);
    
            // Retornem una resposta JSON amb l'estatus i el comentari creat
            return response()->json(['status' => 'correcto', 'data' => $comentari], 201);
        }
    

    /**
 * Mostra un comentari específic.
 * 
 * @OA\Get(
 *     path="/comentaris/{id}",
 *     summary="Obté un comentari per ID",
 *     tags={"Comentaris"},
 *     @OA\Parameter(
 *         name="id",
 *         description="ID del comentari",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comentari trobat",
 *         @OA\JsonContent(ref="#/components/schemas/Comentari")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Comentari no trobat"
 *     )
 * )
 */
    public function show(string $id)
    {
        try {
            // Busca el comentari pel seu ID
            $comentari = Comentaris::findOrFail($id);

            // Retornem una resposta JSON amb l'estatus i les dades del comentari
            return response()->json(['status' => 'correcto', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el comentari no es troba, retornem un error
            return response()->json(['status' => 'Error', 'message' => 'Comentari no trobat'], 404);
        }
    }

    /**
 * Actualitza un comentari existent.
 * 
 * @OA\Put(
 *     path="/comentaris/{id}",
 *     summary="Actualitza un comentari",
 *     tags={"Comentaris"},
 *     @OA\Parameter(
 *         name="id",
 *         description="ID del comentari",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"usuari_id", "espai_id", "data"},
 *             @OA\Property(property="usuari_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=2),
 *             @OA\Property(property="data", type="string", format="date-time", example="2023-01-02T00:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comentari actualitzat",
 *         @OA\JsonContent(ref="#/components/schemas/Comentari")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Comentari no trobat"
 *     )
 * )
 */
    public function update(Request $request, string $id)
    {
        try {
            $comentari = Comentaris::findOrFail($id);

            // Validació de dades
            $validatedData = $request->validate([
                'usuari_id' => 'required|exists:usuaris,id', 
                'espai_id' => 'required|exists:espais,id',   
                'data' => 'required|date'
            ]);

            // Actualització del comentari
            $comentari->update($validatedData);

            return response()->json(['status' => 'success', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 404);
        }
    }

    /**
 * Elimina un comentari existent.
 * 
 * @OA\Delete(
 *     path="/comentaris/{id}",
 *     summary="Elimina un comentari",
 *     tags={"Comentaris"},
 *     @OA\Parameter(
 *         name="id",
 *         description="ID del comentari",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Comentari eliminat",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Comentari eliminat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Comentari no trobat"
 *     )
 * )
 */
    public function destroy(string $id)
    {
        try {
            $comentari = Comentaris::findOrFail($id);
            $comentari->delete();
            return response()->json(['status' => 'success', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
