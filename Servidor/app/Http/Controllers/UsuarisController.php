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
        $tuples = Usuaris::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $reglesValidacio = [
    //         'nom' => 'required|string|max:255',
    //         'llinatges' => 'required|string|max:255',
    //         'dni' => 'required|string|max:20',
    //         'mail' => 'required|email|unique:usuaris,mail|max:255',
    //         'contrasenya' => 'required|string|min:6',
    //         'rol' => 'required|in:usuari,administrador,gestor',
    //         'data_baixa' => 'nullable|date',
    //     ];

    //     $missatges = [
    //         'required' => 'El camp :attribute és obligatori.',
    //         'unique' => 'El :attribute ja està en ús.',
    //         'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
    //         'min' => 'La :attribute ha de tenir almenys :min caràcters.',
    //         'in' => 'El valor seleccionat per a :attribute no és vàlid.',
    //         'date' => 'El camp :attribute ha de ser una data vàlida.',
    //     ];

    //     $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
    //     if (!$validacio->fails()) {
    //         $contrasenya = Hash::make($request->contrasenya);
    //         $request->merge(['contrasenya' => $contrasenya]);
    //         $tupla = Usuaris::create($request->all());
    //         return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
    //     } else {
    //         return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
    //     }
    // }
    public function store(Request $request)
    {
        $fillableAttributes = [
            'nom',
            'llinatges',
            'dni',
            'mail',
            'contrasenya',
        ];

        $defaultValues = [
            'rol' => 'usuari',
            'data_baixa' => null,
            'api_token' => null,
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

        $missatges = [
            'required' => 'El camp :attribute és obligatori.',
            'unique' => 'El :attribute ja està en ús.',
            'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
            'min' => 'La :attribute ha de tenir almenys :min caràcters.',
        ];

        if ($request->has(['md_rol', 'md_id'])) {
            $reglesValidacio = [
                'rol' => 'required|in:usuari,administrador,gestor',
            ];

            $validacio = Validator::make($request->only(['rol']), $reglesValidacio);

            if (!$validacio->fails()) {
                $defaultValues['rol'] = $request->input('rol'); // Asigna el valor de 'rol' si es válido
            } else {
                return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
            }
        }

        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

        if ($validacio->fails()) {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }

        $contrasenya = Hash::make($request->contrasenya);
        $request->merge(['contrasenya' => $contrasenya]);

        // Combinar los atributos fillable con los valores predeterminados
        $dataToInsert = array_merge($request->only($fillableAttributes), $defaultValues);

        $tupla = Usuaris::create($dataToInsert);

        return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
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
        $tupla = Usuaris::findOrFail($id);
        $reglesValidacio = [
            'nom' => 'required|string|max:255',
            'llinatges' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'mail' => 'required|email|unique:usuaris,mail|max:255',
            'contrasenya' => 'required|string|min:6',
            'rol' => 'required|in:usuari,administrador,gestor',
            'data_baixa' => 'nullable|date',
        ];

        $missatges = [
            'required' => 'El camp :attribute és obligatori.',
            'unique' => 'El :attribute ja està en ús.',
            'email' => 'El :attribute ha de ser una adreça de correu electrònic vàlida.',
            'min' => 'La :attribute ha de tenir almenys :min caràcters.',
            'in' => 'El valor seleccionat per a :attribute no és vàlid.',
            'date' => 'El camp :attribute ha de ser una data vàlida.',
        ];

        $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);
        if (!$validacio->fails()) {
            if ($request->filled('contrasenya')) {
                $novaContrasenya = Hash::make($request->contrasenya);
                $request->merge(['contrasenya' => $novaContrasenya]);
            }
            if ($request->filled('rol')) {
                $rol = Hash::make($request->rol);
                $request->merge(['rol' => $rol]);
            }
            $tupla->update($request->all());
            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } else {
            return response()->json(['status' => 'validation error', 'data' => $validacio->errors()->all()], 400);
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
            $usuari->update(['data_baixa' => now()]);
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
