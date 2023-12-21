<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipus;

/**
 * @OA\Tag(
 *     name="Tipus",
 *     description="Operacions per a Tipus"
 * )
 */
class TipusController extends Controller
{
    /**
     * Muestra una lista de todos los tipos.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/tipus",
     *     tags={"Tipus"},
     *     summary="Llista tots els tipus",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els tipus",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Tipus")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $tipus = Tipus::all();
        return response()->json(['tipus' => $tipus]);
    }

    /**
     * Almacena un nuevo tipo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/tipus",
     *     tags={"Tipus"},
     *     summary="Crea un nou tipus",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_tipus' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $tipus = Tipus::create($request->all());

        return response()->json(['message' => 'Tipo creado correctamente', 'tipus' => $tipus]);
    }

    /**
     * Muestra el tipo especificado.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Mostra un tipus específic",
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
     *         description="Retorna el tipus especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     )
     * )
     */
    public function show(Tipus $tipus)
    {
        return response()->json(['tipus' => $tipus]);
    }

    /**
     * Actualiza el tipo especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Actualitza un tipus específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Tipus")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipus actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, Tipus $tipus)
    {
        $request->validate([
            'nom_tipus' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $tipus->update($request->all());

        return response()->json(['message' => 'Tipo actualizado correctamente', 'tipus' => $tipus]);
    }

    /**
     * Elimina el tipo especificado de la base de datos.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/tipus/{id}",
     *     tags={"Tipus"},
     *     summary="Elimina un tipus específic",
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
     *         description="Tipus eliminat correctament"
     *     )
     * )
     */
    public function destroy(Tipus $tipus)
    {
        $tipus->delete();

        return response()->json(['message' => 'Tipo eliminado correctamente']);
    }
}
