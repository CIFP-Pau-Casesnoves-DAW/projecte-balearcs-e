<?php

namespace App\Http\Controllers;

use App\Models\Comentaris;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ComentarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tuples = Comentaris::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Comentari no trobat'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.   
     */
    public function store(Request $request)
    {
        try {
            $mdId = $request->md_id;

            $request->merge(['data' => Carbon::now()]);
            $request->merge(['usuari_id' => $mdId]);

            $reglesValidacio = [
                'comentari' => 'required|string|max:2000',
                'espai_id' => 'required|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            $tupla = Comentaris::create($request->all());

            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $tupla = Comentaris::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobat'], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $tupla = Comentaris::findOrFail($id);

            $reglesValidacio = [
                'comentari' => 'nullable|string|max:2000',
                'espai_id' => 'nullable|integer',
            ];

            $missatges = [
                'required' => 'El camp :attribute és obligatori.',
                'max' => 'El :attribute ha de tenir màxim :max caràcters.'
            ];

            $mdRol = $request->md_rol;

            $validacio = Validator::make($request->all(), $reglesValidacio, $missatges);

            if ($validacio->fails()) {
                throw new \Illuminate\Validation\ValidationException($validacio);
            }

            if ($request->filled('validat') && $mdRol == 'administrador') {
                $comentari = Comentaris::find($id);
                $comentari->validat = $request->input('validat');
                $comentari->save();
            }

            if ($request->filled('usuari_id') && $mdRol == 'administrador') {
                $comentari = Comentaris::find($id);
                $comentari->usuari_id = $request->input('usuari_id');
                $comentari->save();
            }

            $request->merge(['data' => Carbon::now()]);
            $tupla->update($request->all());

            return response()->json(['status' => 'success', 'data' => $tupla], 200);
        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json(['status' => 'error', 'data' => $validationException->errors()], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $comentari = Comentaris::findOrFail($id);
            $comentari->delete();
            return response()->json(['status' => 'success', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        } catch (\Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 500);
        }
    }
}
