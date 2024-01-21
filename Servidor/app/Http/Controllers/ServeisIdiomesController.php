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
     * @OA\Schema(
     *    schema="ServeisIdiomes",
     *   type="object",
     *   @OA\Property(property="idioma_id", type="integer", example="1"),
     *   @OA\Property(property="servei_id", type="integer", example="1"),
     *   @OA\Property(property="traduccio", type="string", example="Fotografia"),
     *   @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
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
 *     path="/serveisidiomes",
 *     tags={"ServeisIdiomes"},
 *     summary="Crea una nova traducció de servei",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear la traducció de servei",
 *         @OA\JsonContent(
 *             required={"idioma_id", "servei_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example=1),
 *             @OA\Property(property="servei_id", type="integer", example=1),
 *             @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de servei creada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio creada correctamente"),
 *             @OA\Property(property="servei_idioma", ref="#/components/schemas/ServeisIdiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", type="object")
 *         )
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
 *     path="/serveisidiomes/{serveisIdioma}",
 *     tags={"ServeisIdiomes"},
 *     summary="Mostra una traducció de servei específica",
 *     @OA\Parameter(
 *         name="serveisIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció de servei a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna la traducció de servei específica",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio mostrada correctamente"),
 *             @OA\Property(property="servei_idioma", ref="#/components/schemas/ServeisIdiomes")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció de servei no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio no encontrada")
 *         )
 *     )
 * )
 * 
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
 *     path="/api/serveisidiomes/{serveiIdioma}",
 *     tags={"ServeisIdiomes"},
 *     summary="Actualitza una traducció de servei específica",
 *     @OA\Parameter(
 *         name="serveiIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció del servei a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la traducció del servei",
 *         @OA\JsonContent(
 *             required={"idioma_id", "servei_id", "traduccio"},
 *             @OA\Property(property="idioma_id", type="integer", example="1"),
 *             @OA\Property(property="servei_id", type="integer", example="1"),
 *             @OA\Property(property="traduccio", type="string", example="Fotografia"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de servei actualitzada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio actualizada correctamente"),
 *             @OA\Property(property="servei_idioma", ref="#/components/schemas/ServeisIdiomes")
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
 *         description="Traducció de servei no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio no encontrada")
 *         )
 *     )
 * )
 */
    public function update(Request $request, ServeisIdiomes $serveisIdioma)
    {
        $request->validate([
            'idioma_id' => 'required|exists:idiomes,id',
            'servei_id' => 'required|exists:serveis,id',
            'traduccio' => 'required|string',
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
 *     path="/api/serveisidiomes/{serveiIdioma}",
 *     tags={"ServeisIdiomes"},
 *     summary="Elimina una traducció de servei específica",
 *     @OA\Parameter(
 *         name="serveiIdioma",
 *         in="path",
 *         required=true,
 *         description="ID de la traducció del servei a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Traducció de servei eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio eliminada correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Traducció de servei no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Traducción de servicio no encontrada")
 *         )
 *     )
 * )
 */
    public function destroy(ServeisIdiomes $serveisIdioma)
    {
        $serveisIdioma->delete();

        return response()->json(['message' => 'Traducción de servicio eliminada correctamente']);
    }
}
