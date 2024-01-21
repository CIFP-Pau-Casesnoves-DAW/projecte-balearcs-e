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
 *     path="/serveis",
 *     summary="Obté una llista de tots els serveis",
 *     tags={"Serveis"},
 *     @OA\Response(
 *         response=200,
 *         description="Llista de serveis obtinguda amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="serveis",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Servei")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Servei",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nom_servei", type="string"),
 *     @OA\Property(property="data_baixa", type="string", format="date", nullable=true),
 *     // Altres propietats del model Servei
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
 *     path="/serveis",
 *     summary="Crea un nou servei",
 *     tags={"Serveis"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a crear un nou servei",
 *         @OA\JsonContent(
 *             required={"nom_servei"},
 *             @OA\Property(property="nom_servei", type="string", example="Servei de guia turística"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servicio creado correctamente"),
 *             @OA\Property(property="servei", ref="#/components/schemas/Servei")
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
 *     path="/serveis/{servei}",
 *     summary="Mostra un servei específic",
 *     tags={"Serveis"},
 *     @OA\Parameter(
 *         name="servei",
 *         in="path",
 *         required=true,
 *         description="ID del servei a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei mostrat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="servei", ref="#/components/schemas/Servei")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Servei no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servei no trobat")
 *         )
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
 *     path="/serveis/{servei}",
 *     summary="Actualitza un servei específic",
 *     tags={"Serveis"},
 *     @OA\Parameter(
 *         name="servei",
 *         in="path",
 *         required=true,
 *         description="ID del servei a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar el servei",
 *         @OA\JsonContent(
 *             required={"nom_serveis"},
 *             @OA\Property(property="nom_serveis", type="string", example="Internet"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servicio actualizado correctamente"),
 *             @OA\Property(property="servei", ref="#/components/schemas/Servei")
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
 *         description="Servei no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servei no trobat")
 *         )
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
 *     path="/serveis/{servei}",
 *     summary="Elimina un servei específic",
 *     tags={"Serveis"},
 *     @OA\Parameter(
 *         name="servei",
 *         in="path",
 *         required=true,
 *         description="ID del servei a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servicio eliminado correctamente")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Servei no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Servei no trobat")
 *         )
 *     )
 * )
 */
    public function destroy(Serveis $servei)
    {
        $servei->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente']);
    }
}
