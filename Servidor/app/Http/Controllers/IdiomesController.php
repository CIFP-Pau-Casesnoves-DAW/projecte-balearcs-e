<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idioma;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

/**
 * @OA\Tag(
 *     name="Idioma",
 *     description="Operacions per a Idiomes"
 * )
 */
class IdiomesController extends Controller
{

    /**
 * @OA\Get(
 *     path="/idiomes",
 *     summary="Llista tots els idiomes",
 *     tags={"Idioma"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de tots els idiomes disponibles",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="idiomes",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Idioma")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Idioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Català")
 *     
 * )
 */
    public function index()
    {
        $idiomes = Idioma::all();
        return response()->json(['idiomes' => $idiomes], 200);
    }


    /**
 * @OA\Post(
 *     path="/idiomes",
 *     summary="Crea un nou idioma",
 *     tags={"Idioma"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a la creació d'un nou idioma",
 *         @OA\JsonContent(
 *             type="object",
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Francès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Idioma creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="idioma", type="object", ref="#/components/schemas/Idioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Idioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="nom", type="string", example="Francès")
 *     
 * )
 */
    public function store(Request $request)
    {
        $reglesValidacio = [
            'nom' => 'required|string|max:255'
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }

        $idioma = Idioma::create($request->all());
        return response()->json(['idioma' => $idioma], 200);
    }

    /**
 * @OA\Get(
 *     path="/idiomes/{id}",
 *     summary="Obté un idioma específic",
 *     tags={"Idioma"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma a obtenir",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Idioma trobat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="idioma", type="object", ref="#/components/schemas/Idioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Idioma no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Idioma no trobat")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Idioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Català")
 *     // Afegir altres propietats del model Idioma si són necessàries.
 * )
 */
    public function show($id)
    {
        try {
            $idioma = Idioma::findOrFail($id);
            return response()->json(['idioma' => $idioma], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Idioma no trobat'], 404);
        }
    }

    /**
 * @OA\Put(
 *     path="/idiomes/{id}",
 *     summary="Actualitza un idioma existent",
 *     tags={"Idioma"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a l'actualització de l'idioma",
 *         @OA\JsonContent(
 *             type="object",
 *             required={"nom"},
 *             @OA\Property(property="nom", type="string", example="Anglès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Idioma actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="idioma", type="object", ref="#/components/schemas/Idioma")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Idioma no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Idioma no trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error desconegut",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error desconegut")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Idioma",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="nom", type="string", example="Anglès")
 * 
 *     
 * )
 */
    public function update(Request $request, $id)
    {
        try {
            $reglesValidacio = ['nom' => 'required|string|max:255'];

            $validacio = Validator::make($request->all(), $reglesValidacio);
            if ($validacio->fails()) {
                return response()->json(['errors' => $validacio->errors()], 400);
            }

            $idioma = Idioma::findOrFail($id);
            $idioma->update($request->all());
            return response()->json(['idioma' => $idioma], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Idioma no trobat'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error desconegut'], 500);
        }
    }


    /**
 * @OA\Delete(
 *     path="/idiomes/{id}",
 *     summary="Elimina un idioma específic",
 *     tags={"Idioma"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'idioma a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Idioma eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Idioma eliminat correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Idioma no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Idioma no trobat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error desconegut",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error desconegut")
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        try {
            $idioma = Idioma::findOrFail($id);
            $idioma->delete();
            return response()->json(['message' => 'Idioma eliminat correctament'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Idioma no trobat'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error desconegut'], 500);
        }
    }
}
