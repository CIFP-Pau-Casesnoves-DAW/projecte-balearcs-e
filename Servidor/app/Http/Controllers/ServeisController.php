<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serveis;

/**
 * @OA\Tag(
 *     name="Serveis",
 *     description="Operacions per a Serveis"
 * )
 */
class ServeisController extends Controller
{
    /**
     * Muestra una lista de todos los servicios.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/serveis",
     *     tags={"Serveis"},
     *     summary="Llista tots els serveis",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de serveis",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Serveis")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $serveis = Serveis::all();
        return response()->json(['serveis' => $serveis]);
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/serveis",
     *     tags={"Serveis"},
     *     summary="Crea un nou servei",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Serveis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Servei creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_serveis' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $servei = Serveis::create($request->all());

        return response()->json(['message' => 'Servicio creado correctamente', 'servei' => $servei]);
    }

    /**
     * Muestra el servicio especificado.
     *
     * @param  \App\Models\Serveis  $servei
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/serveis/{id}",
     *     tags={"Serveis"},
     *     summary="Mostra un servei específic",
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
     *         description="Retorna el servei especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Serveis")
     *     )
     * )
     */
    public function show(Serveis $servei)
    {
        return response()->json(['servei' => $servei]);
    }

    /**
     * Actualiza el servicio especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servei  $servei
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/serveis/{id}",
     *     tags={"Serveis"},
     *     summary="Actualitza un servei específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Serveis")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Servei actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, Serveis $servei)
    {
        $request->validate([
            'nom_serveis' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $servei->update($request->all());

        return response()->json(['message' => 'Servicio actualizado correctamente', 'servei' => $servei]);
    }

    /**
     * Elimina el servicio especificado de la base de datos.
     *
     * @param  \App\Models\Serveis  $servei
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/serveis/{id}",
     *     tags={"Serveis"},
     *     summary="Elimina un servei específic",
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
     *         description="Servei eliminat correctament"
     *     )
     * )
     */
    public function destroy(Serveis $servei)
    {
        $servei->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente']);
    }
}
