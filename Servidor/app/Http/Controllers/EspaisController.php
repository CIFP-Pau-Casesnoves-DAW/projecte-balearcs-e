<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espais;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Usuaris;

/**
 * @OA\Tag(
 *     name="Espai",
 *     description="Operacions per a Espais"
 * )
 */
class EspaisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/espais",
     *     tags={"Espai"},
     *     summary="Llista tots els espais",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els espais",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Espai")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tuples = Espais::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/espais",
     *     tags={"Espai"},
     *     summary="Crea un nou espai",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades necessàries per a crear un nou espai",
     *         @OA\JsonContent(
     *             required={"nom", "descripcio", "carrer", "numero", "mail", "arquitecte_id", "gestor_id", "tipus_id", "municipi_id"},
     *             @OA\Property(property="nom", type="string", example="Edifici Històric"),
     *             @OA\Property(property="descripcio", type="string", example="Descripció detallada de l'edifici"),
     *             @OA\Property(property="carrer", type="string", example="Carrer de l'Exemple"),
     *             @OA\Property(property="numero", type="string", example="123"),
     *             @OA\Property(property="pis_porta", type="string", example="1r 2a", nullable=true),
     *             @OA\Property(property="web", type="string", format="url", example="https://exemple.com", nullable=true),
     *             @OA\Property(property="mail", type="string", format="email", example="contacte@exemple.com"),
     *             @OA\Property(property="grau_acc", type="string", enum={"baix", "mig", "alt"}, nullable=true),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-01-01", nullable=true),
     *             @OA\Property(property="arquitecte_id", type="integer", example=1),
     *             @OA\Property(property="gestor_id", type="integer", example=2),
     *             @OA\Property(property="tipus_id", type="integer", example=3),
     *             @OA\Property(property="municipi_id", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai creat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Espai")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $defaultValues = [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $reglesValidacio = [
                'nom' => 'required|string|max:255',
                'descripcio' => 'required|string',
                'carrer' => 'required|string|max:255',
                'numero' => 'required|string|max:10',
                'pis_porta' => 'nullable|string|max:50',
                'web' => 'nullable|string|max:255',
                'mail' => 'required|email|max:255',
                'grau_acc' => 'nullable|in:baix,mig,alt',
                'arquitecte_id' => 'required|exists:arquitectes,id',
                'gestor_id' => 'required|exists:usuaris,id',
                'tipus_id' => 'required|exists:tipus,id',
                'municipi_id' => 'required|exists:municipis,id',
                'destacat' => 'nullable|boolean',
                'any_cons' => 'nullable|integer'
            ];

            $request->merge($defaultValues);

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'string' => 'El camp :attribute ha de ser una cadena de caràcters.',
                'max' => 'El camp :attribute no pot tenir més de :max caràcters.',
                'url' => 'El camp :attribute ha de ser una URL vàlida.',
                'email' => 'Introduïu una adreça de correu electrònic vàlida.',
                'in' => 'El camp :attribute ha de ser baix, mig o alt.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
                'exists' => 'El :attribute seleccionat no és vàlid.',
                'boolean' => 'El camp :attribute ha de ser un valor booleà.',
                'year' => 'El camp :attribute ha de ser un any vàlid.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Espais::create($request->all());


            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/espais/{id}",
     *     tags={"Espai"},
     *     summary="Mostra un espai específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna l'espai especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Espai")
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $tupla = Espais::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/espais/{id}",
     *     tags={"Espai"},
     *     summary="Actualitza un espai específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'espai a actualitzar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dades per a actualitzar un espai",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nom", type="string", example="Edifici Modernitzat"),
     *             @OA\Property(property="descripcio", type="string", example="Nova descripció de l'edifici"),
     *             @OA\Property(property="carrer", type="string", example="Carrer de la Innovació"),
     *             @OA\Property(property="numero", type="string", example="456"),
     *             @OA\Property(property="pis_porta", type="string", example="2n 3a", nullable=true),
     *             @OA\Property(property="web", type="string", format="url", example="https://exemplemodernitzat.com", nullable=true),
     *             @OA\Property(property="mail", type="string", format="email", example="modernitzat@exemple.com"),
     *             @OA\Property(property="grau_acc", type="string", enum={"baix", "mig", "alt"}, nullable=true),
     *             @OA\Property(property="data_baixa", type="string", format="date", example="2023-02-01", nullable=true),
     *             @OA\Property(property="arquitecte_id", type="integer", example=2),
     *             @OA\Property(property="gestor_id", type="integer", example=3),
     *             @OA\Property(property="tipus_id", type="integer", example=4),
     *             @OA\Property(property="municipi_id", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai actualitzat correctament",
     *         @OA\JsonContent(ref="#/components/schemas/Espai")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validació",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Espai no trobat",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Espai no trobat")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Espais::findOrFail($id);

            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'descripcio' => 'nullable|string',
                'carrer' => 'nullable|string|max:255',
                'numero' => 'nullable|string|max:10',
                'pis_porta' => 'nullable|string|max:50',
                'web' => 'nullable|string|max:255',
                'mail' => 'nullable|email|max:255',
                'grau_acc' => 'nullable|in:baix,mig,alt',
                'arquitecte_id' => 'nullable|exists:arquitectes,id',
                'gestor_id' => 'nullable|exists:usuaris,id',
                'tipus_id' => 'nullable|exists:tipus,id',
                'municipi_id' => 'nullable|exists:municipis,id',
                'destacat' => 'nullable|boolean',
                'any_cons' => 'nullable|integer'
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'string' => 'El camp :attribute ha de ser una cadena de caràcters.',
                'max' => 'El camp :attribute no pot tenir més de :max caràcters.',
                'url' => 'El camp :attribute ha de ser una URL vàlida.',
                'email' => 'Introduïu una adreça de correu electrònic vàlida.',
                'in' => 'El camp :attribute ha de ser baix, mig o alt.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
                'exists' => 'El :attribute seleccionat no és vàlid.',
                'boolean' => 'El camp :attribute ha de ser un valor booleà.',
                'year' => 'El camp :attribute ha de ser un any vàlid.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('arquitecte_id') && $mdRol == 'administrador') {
                $espai = Espais::find($id);
                $espai->arquitecte_id = $request->input('arquitecte_id');
                $espai->save();
            }

            if ($request->filled('gestor_id') && $mdRol == 'administrador') {
                $espai = Espais::find($id);
                $espai->gestor_id = $request->input('gestor_id');
                $espai->save();
            }

            if ($request->filled('tipus_id') && $mdRol == 'administrador') {
                $espai = Espais::find($id);
                $espai->tipus_id = $request->input('tipus_id');
                $espai->save();
            }

            if ($request->filled('municipi_id') && $mdRol == 'administrador') {
                $espai = Espais::find($id);
                $espai->municipi_id = $request->input('municipi_id');
                $espai->save();
            }

            if ($request->filled('destacat') && $mdRol == 'administrador') {
                $espai = Espais::find($id);
                $espai->destacat = $request->input('destacat');
                $espai->save();
            }

            $tupla->update($request->all());
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/espais/{id}",
     *     tags={"Espai"},
     *     summary="Elimina un espai específic",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Espai eliminat correctament",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Espai eliminat correctament")
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
            return response()->json(['status' => 'Error'], 400);
        }
    }

    // No eliminamos un espacio, solo ponemos fecha de baja
    public function delete(string $id)
    {
        try {
            $espai = Espais::findOrFail($id);
            $espai->data_baixa = now();
            $espai->save();
            return response()->json(['status' => 'success', 'data' => $espai], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
