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
     *     path="/api/puntsinteres",
     *     tags={"PuntsInteres"},
     *     summary="Llista tots els punts d'interès",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de punts d'interès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PuntsInteres")
     *         )
     *     )
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
     *     path="/api/puntsinteres",
     *     tags={"PuntsInteres"},
     *     summary="Crea un nou punt d'interès",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès creat correctament"
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Mostra un punt d'interès específic",
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
     *         description="Retorna el punt d'interès especificat",
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Actualitza un punt d'interès específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/PuntsInteres")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Punt d'interès actualitzat correctament"
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
     *     path="/api/puntsinteres/{id}",
     *     tags={"PuntsInteres"},
     *     summary="Elimina un punt d'interès específic",
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
     *         description="Punt d'interès eliminat correctament"
     *     )
     * )
     */
    public function destroy(PuntsInteres $puntInteres)
    {
        $puntInteres->delete();

        return response()->json(['message' => 'Punto de interés eliminado correctamente']);
    }
}
