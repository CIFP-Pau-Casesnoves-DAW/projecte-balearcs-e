<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Illa;

/**
 * @OA\Tag(
 *     name="Illes",
 *     description="Operacions relacionades amb les Illes"
 * )
 */
class IllaController extends Controller
{
    /**
     * Muestra una lista de todas las islas.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Llista totes les illes",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de totes les illes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Illa")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $illes = Illa::all();
        return response()->json(['illes' => $illes]);
    }

    /**
     * Almacena una nueva isla en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/illes",
     *     tags={"Illes"},
     *     summary="Crea una nova illa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Illa")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illa creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $illa = Illa::create($request->all());

        return response()->json(['message' => 'Isla creada correctamente', 'illa' => $illa]);
    }

    /**
     * Muestra la isla especificada.
     *
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Mostra una illa específica",
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
     *         description="Retorna la illa especificada",
     *         @OA\JsonContent(ref="#/components/schemas/Illa")
     *     )
     * )
     */
    public function show(Illa $illa)
    {
        return response()->json(['illa' => $illa]);
    }

    /**
     * Actualiza la isla especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Actualitza una illa específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/Illa")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Illa actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, Illa $illa)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $illa->update($request->all());

        return response()->json(['message' => 'Isla actualizada correctamente', 'illa' => $illa]);
    }

    /**
     * Elimina la isla especificada de la base de datos.
     *
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/illes/{id}",
     *     tags={"Illes"},
     *     summary="Elimina una illa específica",
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
     *         description="Illa eliminada correctament"
     *     )
     * )
     */
    public function destroy(Illa $illa)
    {
        $illa->delete();

        return response()->json(['message' => 'Isla eliminada correctamente']);
    }
}
