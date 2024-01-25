<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * @OA\Tag(
 *    name="Usuaris",
 *   description="Operacions per a usuaris"
 * )
 * 
 */

class UsuarisController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/usuaris",
 *     operationId="getUsuaris",
 *     tags={"Usuaris"},
 *     summary="Obtenir tots els usuaris",
 *     description="Retorna una llista de tots els usuaris",
 *     @OA\Response(
 *         response=200,
 *         description="Llista d'usuaris",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object", example={"field_name": {"Error message"}})
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error intern del servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Missatge d'error intern del servidor")
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Usuari",
 *     type="object",
 *     title="Usuari",
 *     properties={
 *         @OA\Property(property="id", type="integer", format="int64", description="ID de l'usuari"),
 *         @OA\Property(property="nom", type="string", description="Nom de l'usuari"),
 *         @OA\Property(property="cognom", type="string", description="Cognom de l'usuari"),
 *         @OA\Property(property="email", type="string", format="email", description="Adreça de correu de l'usuari"),
 *         @OA\Property(property="data_naixement", type="string", format="date", description="Data de naixement de l'usuari"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Data de creació de l'usuari"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", description="Data de modificació de l'usuari"),
 *         @OA\Property(property="deleted_at", type="string", format="date-time", description="Data de baixa de l'usuari")
 *    }
 * )
 *
 */
    public function index()
    {
        try {
            $tuples = Usuaris::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Post(
 *     path="/usuaris",
 *     summary="Crea un nou usuari",
 *     tags={"Usuaris"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a crear un nou usuari",
 *         @OA\JsonContent(
 *             required={"nom", "llinatges", "dni", "mail", "contrasenya"},
 *             @OA\Property(property="nom", type="string", example="John"),
 *             @OA\Property(property="llinatges", type="string", example="Doe"),
 *             @OA\Property(property="dni", type="string", example="12345678A"),
 *             @OA\Property(property="mail", type="string", format="email", example="johndoe@example.com"),
 *             @OA\Property(property="contrasenya", type="string", format="password", example="secret123"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari creat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Usuari")
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
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/usuaris/{id}",
 *     summary="Obtenir un usuari per ID",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a obtenir",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Dades de l'usuari",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Usuari no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Usuari no trobat")
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
            $tupla = Usuaris::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuari no trobat'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Put(
 *     path="/usuaris/{id}",
 *     summary="Actualitzar un usuari per ID",
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
 *         description="Dades per a actualitzar l'usuari",
 *         @OA\JsonContent(
 *             @OA\Property(property="nom", type="string", example="Nou Nom"),
 *             @OA\Property(property="llinatges", type="string", example="Nous Llinatges"),
 *             @OA\Property(property="dni", type="string", example="12345678A"),
 *             @OA\Property(property="mail", type="string", format="email", example="nou@example.com"),
 *             @OA\Property(property="contrasenya", type="string", example="novaContrasenya"),
 *             @OA\Property(property="rol", type="string", enum={"usuari", "administrador", "gestor"}, example="administrador"),
 *             @OA\Property(property="md_rol", type="string", enum={"administrador"}, example="administrador"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari actualitzat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades o Usuari no trobat",
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
    public function update(Request $request, $id)
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
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/usuaris/{id}",
 *     summary="Eliminar un usuari per ID",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari eliminat correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Usuari no trobat o Error en la validació de dades",
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
    public function destroy($id)
    {
        try {
            $usuari = Usuaris::findOrFail($id);
            $usuari->delete();
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/usuaris/{id}/delete",
 *     summary="Marcar un usuari com a baixa per ID",
 *     tags={"Usuaris"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'usuari a marcar com a baixa",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Usuari marcat com a baixa correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Usuari")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Usuari no trobat o Error en la validació de dades",
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
    // No eliminamos un usuario, solo ponemos fecha de baja
    public function delete($id)
    {
        try {
            $usuari = Usuaris::findOrFail($id);
            $usuari->data_baixa = now();
            $usuari->save();
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}