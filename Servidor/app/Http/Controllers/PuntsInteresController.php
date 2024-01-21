<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PuntsInteres;

/**
 * @OA\Tag(
 *     name="PuntsInteres",
 *     description="Operacions per a Punts d'Interès"
 * )
 */
class PuntsInteresController extends Controller
{
    /**
     * Muestra una lista de todos los puntos de interés.
     *
     * @return \Illuminate\Http\Response
     */

   /**
 * @OA\Get(
 *     path="/punts-interes",
 *     summary="Llista tots els punts d'interès",
 *     tags={"PuntsInteres"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna una llista de tots els punts d'interès",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/PuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="PuntInteres",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="titol", type="string"),
 *     @OA\Property(property="descripcio", type="string"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01"),
 *     @OA\Property(property="espai_id", type="integer", example=1)
 * )
 */
    public function index()
    {
        $puntsInteres = PuntsInteres::all();
        return response()->json(['punts_interes' => $puntsInteres]);
    }

    /**
     * Almacena un nuevo punto de interés en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Post(
 *     path="/punts-interes",
 *     summary="Crea un nou punt d'interès",
 *     tags={"PuntsInteres"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades del nou punt d'interès",
 *         @OA\JsonContent(
 *             required={"titol", "descripcio", "espai_id"},
 *             @OA\Property(property="titol", type="string", example="Castell Bellver"),
 *             @OA\Property(property="descripcio", type="string", example="Un castell gòtic ubicat a Palma."),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01"),
 *             @OA\Property(property="espai_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Punt d'interès creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés creado correctamente"),
 *             @OA\Property(property="punt_interes", ref="#/components/schemas/PuntInteres")
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
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $puntInteres = PuntsInteres::create($request->all());

        return response()->json(['message' => 'Punto de interés creado correctamente', 'punt_interes' => $puntInteres]);
    }

    /**
     * Muestra el punto de interés especificado.
     *
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Get(
 *     path="/punts-interes/{id}",
 *     summary="Mostra un punt d'interès específic",
 *     tags={"PuntsInteres"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del punt d'interès",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detalls del punt d'interès",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="punt_interes", ref="#/components/schemas/PuntInteres")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Punt d'interès no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés no encontrado")
 *         )
 *     )
 * )
 */
    public function show(PuntsInteres $puntInteres)
    {
        return response()->json(['punt_interes' => $puntInteres]);
    }

    /**
     * Actualiza el punto de interés especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PuntInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Put(
 *     path="/punts-interes/{id}",
 *     summary="Actualitza un punt d'interès",
 *     tags={"PuntsInteres"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del punt d'interès a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar el punt d'interès",
 *         @OA\JsonContent(
 *             required={"titol", "descripcio", "espai_id"},
 *             @OA\Property(property="titol", type="string", example="Títol del punt d'interès"),
 *             @OA\Property(property="descripcio", type="string", example="Descripció detallada del punt d'interès"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01"),
 *             @OA\Property(property="espai_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Punt d'interès actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés actualizado correctamente"),
 *             @OA\Property(property="punt_interes", ref="#/components/schemas/PuntInteres")
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
 *         description="Punt d'interès no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés no encontrado")
 *         )
 *     )
 * )
 */

    public function update(Request $request, PuntsInteres $puntInteres)
    {
        $request->validate([
            'titol' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'data_baixa' => 'nullable|date',
            'espai_id' => 'required|exists:espais,id',
        ]);

        $puntInteres->update($request->all());

        return response()->json(['message' => 'Punto de interés actualizado correctamente', 'punt_interes' => $puntInteres]);
    }

    /**
     * Elimina el punto de interés especificado de la base de datos.
     *
     * @param  \App\Models\PuntsInteres  $puntInteres
     * @return \Illuminate\Http\Response
     */

     /**
 * @OA\Delete(
 *     path="/punts-interes/{puntInteres}",
 *     summary="Elimina un punt d'interès",
 *     tags={"PuntsInteres"},
 *     @OA\Parameter(
 *         name="puntInteres",
 *         in="path",
 *         required=true,
 *         description="ID del punt d'interès a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Punt d'interès eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés eliminado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Punt d'interès no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Punto de interés no encontrado")
 *         )
 *     )
 * )
 */
    public function destroy(PuntsInteres $puntInteres)
    {
        $puntInteres->delete();

        return response()->json(['message' => 'Punto de interés eliminado correctamente']);
    }
}
