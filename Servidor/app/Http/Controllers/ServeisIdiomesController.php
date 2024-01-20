<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServeisIdiomes;

/**
 * @OA\Tag(
 *     name="ServeisIdiomes",
 *     description="Operacions per a Serveis Idiomes"
 * )
 */
class ServeisIdiomesController extends Controller
{
    /**
     * Muestra una lista de todas las traducciones de servicios.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/serveisidiomes",
     *     tags={"ServeisIdiomes"},
     *     summary="Llista totes les traduccions de serveis",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de les traduccions de serveis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ServeisIdiomes")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $serveisIdiomes = ServeisIdiomes::all();
        return response()->json(['serveis_idiomes' => $serveisIdiomes]);
    }

    /**
     * Almacena una nueva traducción de servicio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/serveisidiomes",
     *     tags={"ServeisIdiomes"},
     *     summary="Crea una nova traducció de servei",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ServeisIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció de servei creada correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'servei_id' => 'required|exists:serveis,id',
            'traduccio' => 'required|string',
            'data_baixa' => 'nullable|date',
        ]);

        $serveiIdioma = ServeisIdiomes::create($request->all());

        return response()->json(['message' => 'Traducción de servicio creada correctamente', 'servei_idioma' => $serveiIdioma]);
    }

    /**
     * Muestra la traducción de servicio especificada.
     *
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/serveisidiomes/{id}",
     *     tags={"ServeisIdiomes"},
     *     summary="Mostra una traducció de servei específica",
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
     *         description="Retorna la traducció de servei especificada",
     *         @OA\JsonContent(ref="#/components/schemas/ServeisIdiomes")
     *     )
     * )
     */
    public function show(ServeisIdiomes $serveisIdioma)
    {
        return response()->json(['servei_idioma' => $serveisIdioma]);
    }

    /**
     * Actualiza la traducción de servicio especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/serveisidiomes/{id}",
     *     tags={"ServeisIdiomes"},
     *     summary="Actualitza una traducció de servei específica",
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
     *         @OA\JsonContent(ref="#/components/schemas/ServeisIdiomes")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducció de servei actualitzada correctament"
     *     )
     * )
     */
    public function update(Request $request, ServeisIdiomes $serveisIdioma)
    {
        $request->validate([
            'idioma_id' => 'nullable|exists:idiomes,id',
            'servei_id' => 'nullable|exists:serveis,id',
            'traduccio' => 'nullable|string',
            'data_baixa' => 'nullable|date',
        ]);

        $serveisIdioma->update($request->all());

        return response()->json(['message' => 'Traducción de servicio actualizada correctamente', 'servei_idioma' => $serveisIdioma]);
    }

    /**
     * Elimina la traducción de servicio especificada de la base de datos.
     *
     * @param  \App\Models\ServeisIdiomes  $serveisIdioma
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/serveisidiomes/{id}",
     *     tags={"ServeisIdiomes"},
     *     summary="Elimina una traducció de servei específica",
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
     *         description="Traducció de servei eliminada correctament"
     *     )
     * )
     */
    public function destroy(ServeisIdiomes $serveisIdioma)
    {
        $serveisIdioma->delete();

        return response()->json(['message' => 'Traducción de servicio eliminada correctamente']);
    }
}
