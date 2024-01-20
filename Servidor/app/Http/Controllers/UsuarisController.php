<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsuarisController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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

    /**
     * Remove the specified resource from storage.
     */
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
