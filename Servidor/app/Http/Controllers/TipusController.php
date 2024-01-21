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
 *     path="/tipus",
 *     summary="Llista tots els tipus",
 *     tags={"Tipus"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna un llistat de tots els tipus",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Tipus")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
 *     )
 * )
 * @OA\Schema(
 *     schema="Tipus",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom_tipus", type="string", example="Tipus Exemple"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
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
 *     path="/tipus",
 *     summary="Crea un nou tipus",
 *     tags={"Tipus"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a crear un nou tipus",
 *         @OA\JsonContent(
 *             required={"nom_tipus"},
 *             @OA\Property(property="nom_tipus", type="string", example="Tipus Exemple"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipus creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo creado correctamente"),
 *             @OA\Property(property="tipus", ref="#/components/schemas/Tipus")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
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
 *     path="/tipus/{tipus}",
 *     summary="Mostra un tipus específic",
 *     tags={"Tipus"},
 *     @OA\Parameter(
 *         name="tipus",
 *         in="path",
 *         required=true,
 *         description="ID del tipus a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna el tipus sol·licitat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="tipus", ref="#/components/schemas/Tipus")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tipus no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo no encontrado")
 *         )
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
 *     path="/tipus/{tipus}",
 *     summary="Actualitza un tipus específic",
 *     tags={"Tipus"},
 *     @OA\Parameter(
 *         name="tipus",
 *         in="path",
 *         required=true,
 *         description="ID del tipus a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar el tipus",
 *         @OA\JsonContent(
 *             required={"nom_tipus"},
 *             @OA\Property(property="nom_tipus", type="string", example="Museu"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipus actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo actualizado correctamente"),
 *             @OA\Property(property="tipus", ref="#/components/schemas/Tipus")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tipus no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo no encontrado")
 *         )
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
 *     path="/tipus/{tipus}",
 *     summary="Elimina un tipus específic",
 *     tags={"Tipus"},
 *     @OA\Parameter(
 *         name="tipus",
 *         in="path",
 *         required=true,
 *         description="ID del tipus a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipus eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo eliminado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tipus no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Tipo no encontrado")
 *         )
 *     )
 * )
 */
    public function destroy(Tipus $tipus)
    {
        $tipus->delete();

        return response()->json(['message' => 'Tipo eliminado correctamente']);
    }
}
