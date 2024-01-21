<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serveis;
use Illuminate\Support\Facades\Validator;

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
 *     summary="Llista tots els serveis disponibles",
 *     @OA\Response(
 *         response=200,
 *         description="Llista de serveis recuperada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Servei")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Servei",
 *     type="object",
 *     @OA\Property(property="id", type="integer", description="Identificador únic del servei"),
 *     @OA\Property(property="nom", type="string", description="Nom del servei"),
 *     @OA\Property(property="descripcio", type="string", description="Descripció del servei"),
 *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa del servei", nullable=true)
 * )
 */
    public function index()
    {
        try {
            $tuples = Serveis::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *         description="Dades del servei a crear",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom_serveis", type="string", description="Nom del servei"),
 *             @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa del servei", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei creat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                  ref="#/components/schemas/Servei"
 * 
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function store(Request $request)
    {
        try {
            $reglesValidacio = [
                'nom_serveis' => 'required|string|max:255',
                'data_baixa' => 'nullable|date',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Serveis::create($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Recupera un servei per ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei trobat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Servei"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function show($id)
    {
        try {
            $tupla = Serveis::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Actualitza un servei existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del servei",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades a actualitzar del servei",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom_serveis", type="string", example="Servei actualitzat"),
 *             @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-21")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei actualitzat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Servei"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Serveis::findOrFail($id);
            $reglesValidacio = [
                'nom_serveis' => 'nullable|string|max:255',
                'data_baixa' => 'nullable|date',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
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
 *     summary="Elimina un servei existent",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID del servei a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Servei eliminat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 ref="#/components/schemas/Servei"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la sol·licitud",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string")
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $tupla = Serveis::findOrFail($id);
            $tupla->delete();
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}