<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *     name="Usuaris",
 *     description="Operacions per a Usuaris"
 * )
 */
class UsuarisController extends Controller
{
    /**
 * @OA\Get(
 *     path="/usuaris",
 *     summary="Llista tots els usuaris",
 *     tags={"Usuaris"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna una llista de tots els usuaris",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Usuari")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 additionalProperties={
 *                     @OA\Property(type="array", @OA\Items(type="string"))
 *                 }
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Usuari",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Pep"),
 *     @OA\Property(property="llinatges", type="string", example="Garcia"),
 *     @OA\Property(property="dni", type="string", example="12345678A"),
 *     @OA\Property(property="mail", type="string", example="
 *     @OA\Property(property="contrasenya", type="string", example="123456"),
 *     @OA\Property(property="rol", type="string", example="usuari"),
 *     @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *     
 * )
 */
    public function index()
    {
        try {
            $tuples = Usuaris::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        }
    }

 /**
 * @OA\Post(
 *     path="/usuaris",
 *     summary="Crea un nou usuari",
 *     tags={"Usuaris"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'usuari a crear",
 *         @OA\JsonContent(
 *             required={"nom", "llinatges", "dni", "mail", "contrasenya"},
 *             @OA\Property(property="nom", type="string", example="Joan"),
 *             @OA\Property(property="llinatges", type="string", example="Martínez López"),
 *             @OA\Property(property="dni", type="string", example="12345678A"),
 *             @OA\Property(property="mail", type="string", format="email", example="joan@example.com"),
 *             @OA\Property(property="contrasenya", type="string", example="password123"),
 *             // Altres propietats si són necessàries
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcte"),
 *             @OA\Property(property="data", ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 additionalProperties={
 *                     @OA\Property(type="array", @OA\Items(type="string"))
 *                 }
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Usuari",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Pep"),
 *     @OA\Property(property="llinatges", type="string", example="Garcia"),
 *    @OA\Property(property="dni", type="string", example="12345678A"),
 *    @OA\Property(property="mail", type="string", example="
 *    @OA\Property(property="contrasenya", type="string", example="123456"),
 *    @OA\Property(property="rol", type="string", example="usuari"),
 *    @OA\Property(property="data_baixa", type="string", format="date", example="2024-01-01")
 *   
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
                'llinatges' => 'required|string|max:255',
                'dni' => 'required|string|max:20',
                'mail' => 'required|email|unique:usuaris,mail|max:255',
                'contrasenya' => 'required|string|min:6',
            ];

            $request->merge($defaultValues);

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'unique' => 'El :attribute ja està en ús.',
                'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
                'min' => 'La :attribute ha de tenir almenys :min caràcters.',
                'in' => 'El valor seleccionat per a :attribute no és vàlid.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $contrasenya = Hash::make($request->contrasenya);
            $request->merge(['contrasenya' => $contrasenya]);
            $tupla = Usuaris::create($request->all());

            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        }
    }

    /**
 * @OA\Get(
 *     path="/usuaris/{id}",
 *     summary="Mostra un usuari específic",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a mostrar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/Usuari"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Usuari no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Usuaris no trobat")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Usuari",
 *     type="object",
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="llinatges", type="string"),
 *     @OA\Property(property="dni", type="string"),
 *     @OA\Property(property="mail", type="string"),
 *     @OA\Property(property="rol", type="string"),
 *     @OA\Property(property="data_baixa", type="string", format="date")
 *     
 * )
 */
    public function show(string $id)
    {
        try {
            $tupla = Usuaris::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        }
    }

    /**
 * @OA\Put(
 *     path="/usuaris/{id}",
 *     summary="Actualitza un usuari específic",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades de l'usuari per actualitzar",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nom", type="string"),
 *             @OA\Property(property="llinatges", type="string"),
 *             @OA\Property(property="dni", type="string"),
 *             @OA\Property(property="mail", type="string"),
 *             @OA\Property(property="contrasenya", type="string"),
 *             @OA\Property(property="rol", type="string", enum={"usuari", "administrador", "gestor"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/Usuari"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Dades invàlides o error en la validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
 *         )
 *     )
 * )
 */

    public function update(Request $request, string $id)
    {
        try {
            $tupla = Usuaris::findOrFail($id);
            
            $reglesValidacio = [
                'nom' => 'nullable|string|max:255',
                'llinatges' => 'nullable|string|max:255',
                'dni' => 'nullable|string|max:20',
                'mail' => 'nullable|email|unique:usuaris,mail|max:255',
                'contrasenya' => 'nullable|string|min:6',
                'rol' => 'nullable|in:usuari,administrador,gestor',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'unique' => 'El :attribute ja està en ús.',
                'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
                'min' => 'La :attribute ha de tenir almenys :min caràcters.',
                'in' => 'El valor seleccionat per a :attribute no és vàlid.',
                'date' => 'El camp :attribute ha de ser una data vàlida.',
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }
            if ($request->filled('contrasenya')) {
                $novaContrasenya = Hash::make($request->contrasenya);
                $request->merge(['contrasenya' => $novaContrasenya]);
            }

            if ($request->filled('rol') && $mdRol == 'administrador') {
                $usuari = Usuaris::find($id);
                $usuari->rol = $request->input('rol');
                $usuari->save();
            }
            $tupla->update($request->all());
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        }
    }

    
    public function destroy(string $id)
    {
        try {
            $usuari = Usuaris::findOrFail($id);
            $usuari->delete();
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }

    /**
 * @OA\Put(
 *     path="/usuaris/delete/{id}",
 *     summary="Marca un usuari com a inactiu (data de baixa)",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a marcar com a inactiu",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari marcat com a inactiu correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/Usuari"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Usuari no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     )
 * )
 */

    // No eliminamos un usuario, solo ponemos fecha de baja
    public function delete(string $id)
    {
        try {
            $usuari = Usuaris::findOrFail($id);
            $usuari->data_baixa = now();
            $usuari->save();
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}