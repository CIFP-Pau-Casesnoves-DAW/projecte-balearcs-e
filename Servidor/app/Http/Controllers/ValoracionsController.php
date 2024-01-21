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

/**
 * @OA\Schema(
 *     schema="Valoracio",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="puntuacio", type="integer", example="5"),
 *     @OA\Property(property="comentari", type="string", example="Excel·lent servei!"),
 *     @OA\Property(property="data_valoracio", type="string", format="date", example="2024-01-20"),
 *     @OA\Property(property="usuari_id", type="integer", example="10"),
 *     @OA\Property(property="espai_id", type="integer", example="15")
 * )
 * 
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
 *     path="/valoracions",
 *     summary="Obté un llistat de totes les valoracions",
 *     tags={"Valoracions"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna un llistat de totes les valoracions",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="valoracions",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Valoracio")
 *             )
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
 *     path="/valoracions",
 *     summary="Crea una nova valoració",
 *     tags={"Valoracions"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per crear una nova valoració",
 *         @OA\JsonContent(
 *             required={"puntuacio", "data", "usuari_id", "espai_id"},
 *             @OA\Property(property="puntuacio", type="integer", example="4"),
 *             @OA\Property(property="data", type="string", format="date", example="2024-01-20"),
 *             @OA\Property(property="usuari_id", type="integer", example="10"),
 *             @OA\Property(property="espai_id", type="integer", example="15"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Valoració creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoración creada correctamente"),
 *             @OA\Property(property="valoracio", ref="#/components/schemas/Valoracio")
 *         )
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
 *     path="/valoracions/{valoracio}",
 *     summary="Mostra una valoració específica",
 *     tags={"Valoracions"},
 *     @OA\Parameter(
 *         name="valoracio",
 *         in="path",
 *         required=true,
 *         description="ID de la valoració a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la valoració especificada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="valoracio", ref="#/components/schemas/Valoracio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Valoració no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoració no trobada")
 *         )
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
 *     path="/valoracions/{valoracio}",
 *     summary="Actualitza una valoració específica",
 *     tags={"Valoracions"},
 *     @OA\Parameter(
 *         name="valoracio",
 *         in="path",
 *         required=true,
 *         description="ID de la valoració a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per actualitzar la valoració",
 *         @OA\JsonContent(
 *             required={"puntuacio", "data", "usuari_id", "espai_id"},
 *             @OA\Property(property="puntuacio", type="integer", example=5),
 *             @OA\Property(property="data", type="string", format="date", example="2024-01-01"),
 *             @OA\Property(property="usuari_id", type="integer", example=1),
 *             @OA\Property(property="espai_id", type="integer", example=1),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Valoració actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoració actualitzada correctament"),
 *             @OA\Property(property="valoracio", ref="#/components/schemas/Valoracio")
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
 *         description="Valoració no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoració no trobada")
 *         )
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
 *     path="/valoracions/{valoracio}",
 *     summary="Elimina una valoració específica",
 *     tags={"Valoracions"},
 *     @OA\Parameter(
 *         name="valoracio",
 *         in="path",
 *         required=true,
 *         description="ID de la valoració a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Valoració eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoració eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Valoració no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Valoració no trobada")
 *         )
 *     )
 * )
 */
    public function destroy(Valoracions $valoracio)
    {
        $valoracio->delete();

        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }
}
