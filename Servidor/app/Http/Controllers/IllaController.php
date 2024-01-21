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
 *     path="/illes",
 *     summary="Llista totes les illes",
 *     tags={"Illes"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de totes les illes disponibles",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="illes",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Illa")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Illa",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Mallorca"),
 *     @OA\Property(property="zona", type="string", example="Balears")
 *     
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
 *     path="/illes",
 *     summary="Crea una nova illa",
 *     tags={"Illes"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a la creació d'una nova illa",
 *         @OA\JsonContent(
 *             type="object",
 *             required={"nom", "zona"},
 *             @OA\Property(property="nom", type="string", example="Menorca"),
 *             @OA\Property(property="zona", type="string", example="Balears"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Illa creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Illa creada correctament"),
 *             @OA\Property(property="illa", type="object", ref="#/components/schemas/Illa")
 *         )
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
 *     path="/illes/{id}",
 *     summary="Obté detalls d'una illa específica",
 *     tags={"Illes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'illa a obtenir",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalls de l'illa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="illa", type="object", ref="#/components/schemas/Illa")
 *         )
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
 *     path="/illes/{id}",
 *     summary="Actualitza una illa existent",
 *     tags={"Illes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'illa a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a l'actualització de l'illa",
 *         @OA\JsonContent(
 *             type="object",
 *             required={"nom", "zona"},
 *             @OA\Property(property="nom", type="string", example="Eivissa"),
 *             @OA\Property(property="zona", type="string", example="Balears"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Illa actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Illa actualitzada correctament"),
 *             @OA\Property(property="illa", type="object", ref="#/components/schemas/Illa")
 *         )
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
 *     path="/illes/{id}",
 *     summary="Elimina una illa específica",
 *     tags={"Illes"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'illa a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Illa eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Illa eliminada correctament")
 *         )
 *     )
 * )
 */
    public function destroy(Illa $illa)
    {
        $illa->delete();

        return response()->json(['message' => 'Isla eliminada correctamente']);
    }
}
