<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espais;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


/**
 * @OA\Tag(
 *     name="Espais",
 *     description="Operacions per a Espais"
 * )
 */
class EspaisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais",
     *     tags={"Espais"},
     *     summary="Llista tots els espais",
     *     @OA\Response(
     *         response=200,
     *         description="Llista d'espais recuperada amb èxit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="correcto"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Espais")
     *             )
     * 
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
     * @OA\Schema(
     *     schema="Espais",
     *     type="object",
     *     @OA\Property(property="nom", type="string", description="Nom de l'espai"),
     *     @OA\Property(property="descripcio", type="string", description="Descripció de l'espai"),
     *     @OA\Property(property="adreca", type="string", description="Adreça de l'espai"),
     *     @OA\Property(property="mail", type="string", description="Correu electrònic de l'espai"),
     *     @OA\Property(property="grau_acc", type="string", description="Grau d'accessibilitat de l'espai"),
     *     @OA\Property(property="data_baixa", type="string", format="date", description="Data de baixa de l'espai"),
     *     @OA\Property(property="arquitecte_id", type="integer", description="ID de l'arquitecte de l'espai"),
     *     @OA\Property(property="gestor_id", type="integer", description="ID del gestor de l'espai"),
     *     @OA\Property(property="tipus_id", type="integer", description="ID del tipus d'espai"),
     *     @OA\Property(property="municipi_id", type="integer", description="ID del municipi de l'espai")
     *     
     * )
     */

    public function index()
    {
        try {
            $tuples = Espais::all();
            return response()->json(['status' => 'success', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/espais",
     *     tags={"Espais"},
     *     summary="Crea un nou espai",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear un nou espai",
     *         @OA\JsonContent(
     *             required={"nom", "descripcio", "carrer", "numero", "mail"},
     *             @OA\Property(property="nom", type="string", description="Nom de l'espai", maxLength=255),
     *             @OA\Property(property="descripcio", type="string", description="Descripció de l'espai"),
     *             @OA\Property(property="carrer", type="string", description="Carrer de l'espai", maxLength=255),
     *             @OA\Property(property="numero", type="string", description="Número de l'edifici", maxLength=10),
     *             @OA\Property(property="pis_porta", type="string", description="Pis i porta", maxLength=50, nullable=true),
     *             @OA\Property(property="web", type="string", description="Web de l'espai", maxLength=255, nullable=true),
     *             @OA\Property(property="mail", type="string", format="email", description="Correu electrònic de contacte", maxLength=255),
     *             @OA\Property(property="grau_acc", type="string", description="Grau d'accessibilitat", enum={"baix", "mig", "alt"}, nullable=true),
     *             @OA\Property(property="any_cons", type="integer", description="Any de construcció", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Nou espai creat correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="correcte"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espais")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validació de dades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="data", type="object", additionalProperties={"type":"string"})
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
                'nom' => 'required|string|max:255',
                'descripcio' => 'required|string',
                'carrer' => 'required|string|max:255',
                'numero' => 'required|string|max:10',
                'pis_porta' => 'nullable|string|max:50',
                'web' => 'nullable|string|max:255',
                'mail' => 'required|email|max:255',
                'grau_acc' => 'filled|in:baix,mig,alt',
                'any_cons' => 'filled|integer',
                'arquitecte_id' => 'filled|int|exists:arquitectes,id',
                'tipus_id' => 'required|int|exists:tipus,id',
                'gestor_id' => 'filled|int|exists:usuaris,id',
                'municipi_id' => 'filled|int|exists:municipis,id'
            ];

            $missatges = [
                'exists' => ':attribute ha de existir',
                'filled' => 'El camp :attribute no pot estar buit',
                'required' => 'El camp :attribute és obligatori.',
                'string' => 'El camp :attribute ha de ser una cadena de caràcters.',
                'max' => 'El camp :attribute no pot tenir més de :max caràcters.',
                'url' => 'El camp :attribute ha de ser una URL vàlida.',
                'email' => 'Introduïu una adreça de correu electrònic vàlida.',
                'in' => 'El camp :attribute ha de ser baix, mig o alt.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
                'boolean' => 'El camp :attribute ha de ser un valor booleà.',
                'year' => 'El camp :attribute ha de ser un any vàlid.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Espais::create($request->all());

            if ($request->filled('gestor_id')) {
                $tupla->gestor_id = $request->input('gestor_id');
                $tupla->save();
            }
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/espais/{id}",
     *     tags={"Espais"},
     *     summary="Obté les dades d'un espai específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'espai",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dades de l'espai trobades",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="correcto"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espais")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Espai no trobat",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Espai no trobat")
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
            $tupla = Espais::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/espais/{id}",
     *     tags={"Espais"},
     *     summary="Actualitza un espai existent",
     *     description="Actualitza les dades d'un espai basat en el seu ID",
     *     operationId="updateEspai",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'espai a actualitzar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Dades actualitzades de l'espai",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Espais")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Espais")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dades no vàlides"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espai no trobat"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     * 
     */

    public function update(Request $request, $id)
    {
        try {
            $tupla = Espais::findOrFail($id);

            $reglesValidacio = [
                'nom' => 'filled|string|max:255',
                'descripcio' => 'filled|string',
                'carrer' => 'filled|string|max:255',
                'numero' => 'filled|string|max:10',
                'pis_porta' => 'nullable|string|max:50',
                'web' => 'nullable|string|max:255',
                'mail' => 'filled|email|max:255',
                'grau_acc' => 'filled|in:baix,mig,alt',
                'any_cons' => 'filled|integer',
                'arquitecte_id' => 'filled|int|exists:arquitectes,id',
                'tipus_id' => 'filled|int|exists:tipus,id',
                'gestor_id' => 'filled|int|exists:usuaris,id',
                'municipi_id' => 'filled|int|exists:municipis,id'
            ];

            $missatges = [
                'exists' => ':attribute ha de existir',
                'filled' => 'El camp :attribute no pot estar buit',
                'required' => 'El camp :attribute és obligatori.',
                'string' => 'El camp :attribute ha de ser una cadena de caràcters.',
                'max' => 'El camp :attribute no pot tenir més de :max caràcters.',
                'url' => 'El camp :attribute ha de ser una URL vàlida.',
                'email' => 'Introduïu una adreça de correu electrònic vàlida.',
                'in' => 'El camp :attribute ha de ser baix, mig o alt.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
                'boolean' => 'El camp :attribute ha de ser un valor booleà.',
                'year' => 'El camp :attribute ha de ser un any vàlid.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('gestor_id') && $mdRol == 'administrador') {
                $tupla->gestor_id = $request->input('gestor_id');
                $tupla->save();
            }

            if ($request->filled('destacat') && $mdRol == 'administrador') {
                $tupla->destacat = $request->input('destacat');
                $tupla->save();
            }

            if (empty($request->data_baixa) && $mdRol == 'administrador') {
                $tupla->data_baixa = NULL;
                $tupla->save();
            }

            $tupla->update($request->all());
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/espais/{id}",
     *     tags={"Espais"},
     *     summary="Elimina un espai existent",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'espai a eliminar",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai eliminat correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espais")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Espai no trobat o error en l'eliminació",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Error")
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
            $espai = Espais::findOrFail($id);
            $espai->delete();
            return response()->json(['status' => 'success', 'data' => $espai], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/espais/delete/{id}",
     *     tags={"Espais"},
     *     summary="Marca un espai com a donat de baixa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Identificador únic de l'espai a marcar com a baixa",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai marcat com a baixa correctament",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espais")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Espai no trobat o error en el procés de baixa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="Error")
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

    // No eliminamos un espacio, solo ponemos fecha de baja
    public function delete($id)
    {
        try {
            $espai = Espais::findOrFail($id);
            $espai->data_baixa = now();
            $espai->save();
            return response()->json(['status' => 'success', 'data' => $espai], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'data' => $e], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'data' => $exception->getMessage()], 500);
        }
    }
}
