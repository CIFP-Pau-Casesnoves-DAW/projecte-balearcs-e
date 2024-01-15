<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracio;
use App\Models\Valoracions;

/**
 * @OA\Tag(
 *     name="Valoracions",
 *     description="Operacions per a Valoracions"
 * )
 */
class ValoracionsController extends Controller
{
    /**
     * Muestra una lista de todas las valoraciones.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/valoracions",
     *     tags={"Valoracions"},
     *     summary="Llista totes les valoracions",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de valoracions",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Valoracions")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $valoracions = Valoracions::all();
        return response()->json(['valoracions' => $valoracions]);
    }

    /**
     * Almacena una nueva valoración en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/valoracions",
     *     tags={"Valoracions"},
     *     summary="Crea una nova valoració",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'puntuacio' => 'required|integer',
            'data' => 'required|date',
            'usuari_id' => 'required|exists:usuaris,id',
            'espai_id' => 'required|exists:espais,id',
            'data_baixa' => 'nullable|date',
        ]);

        $valoracio = Valoracions::create($request->all());

        return response()->json(['message' => 'Valoración creada correctamente', 'valoracio' => $valoracio]);
    }

    /**
     * Muestra la valoración especificada.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Mostra una valoració específica",
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
     *         description="Retorna la valoració especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     )
     * )
     */
    public function show(Valoracions $valoracio)
    {
        return response()->json(['valoracio' => $valoracio]);
    }

    /**
     * Actualiza la valoración especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Actualitza una valoració específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Valoracions")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Valoració actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, Valoracions $valoracio)
    {
        $request->validate([
            'puntuacio' => 'required|integer',
            'data' => 'required|date',
            'usuari_id' => 'required|exists:usuaris,id',
            'espai_id' => 'required|exists:espais,id',
            'data_baixa' => 'nullable|date',
        ]);

        $valoracio->update($request->all());

        return response()->json(['message' => 'Valoración actualizada correctamente', 'valoracio' => $valoracio]);
    }

    /**
     * Elimina la valoración especificada de la base de datos.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/valoracions/{id}",
     *     tags={"Valoracions"},
     *     summary="Elimina una valoració específica",
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
     *         description="Valoració eliminada correctament"
     *     )
     * )
     */
    public function destroy(Valoracions $valoracio)
    {
        $valoracio->delete();

        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }
}
