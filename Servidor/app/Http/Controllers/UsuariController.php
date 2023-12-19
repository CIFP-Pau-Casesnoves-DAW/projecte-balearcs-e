<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsuariController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $usuaris = Usuari::paginate(10);
        // return view('usuari.index', ['usuaris' => $usuaris]);
        $tuples = Usuari::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
            $tupla = Usuari::create($request->all());
            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $usuari = Usuari::find($id);
        // return view('usuari.show', ['usuari' => $usuari]);
        try {
            $tupla = Usuari::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuari no trobada'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tupla = Usuari::findOrFail($id);
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
            $usuari = Usuari::findOrFail($id);
            $usuari->update(['data_baixa' => Carbon::now()]);
            return response()->json(['status' => 'success', 'data' => $usuari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
