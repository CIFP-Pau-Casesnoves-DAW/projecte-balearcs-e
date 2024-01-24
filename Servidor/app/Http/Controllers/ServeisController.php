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
        try {
            $reglesValidacio = [
                'nom_serveis' => 'required|string|max:255',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
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
    public function show($id)
    {
        try {
            $tupla = Serveis::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'No trobat'], 400);
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
    public function update(Request $request, $id)
    {
        try {
            $tupla = Serveis::findOrFail($id);
            $reglesValidacio = [
                'nom_serveis' => 'nullable|string|max:255',
            ];
            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if (!empty($request->data_baixa)) {
                $request->merge(['data_baixa' => now()]);
            } else if (empty($request->data_baixa)) {
                $request->merge(['data_baixa' => NULL]);
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
