<?php

namespace App\Http\Controllers;

use App\Models\Usuaris;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Usuaris",
 *     description="Operacions per a Usuariss"
 * )
 */
class UsuarisController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/Usuariss",
     *     tags={"Usuaris"},
     *     summary="Llista tots els Usuariss",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els Usuariss",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Usuaris")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // $Usuariss = Usuaris::paginate(10);
        // return view('Usuaris.index', ['Usuariss' => $Usuariss]);
        $tuples = Usuaris::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/Usuariss",
     *     tags={"Usuaris"},
     *     summary="Crea un nou Usuaris",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Usuaris")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuaris creat correctament"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $reglesValidacio = [
            'nom' => 'required|string|max:255',
            'llinatges' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'mail' => 'required|email|unique:Usuariss,mail|max:255',
            'contrasenya' => 'required|string|min:6',
            'rol' => 'required|in:Usuaris,administrador,gestor',
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
            $tupla = Usuaris::create($request->all());
            return response()->json(['status' => 'correcte', 'data' => $tupla], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => $validacio->errors()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/Usuariss/{id}",
     *     tags={"Usuaris"},
     *     summary="Mostra un Usuaris específic",
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
     *         description="Retorna l'Usuaris especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Usuaris")
     *     )
     * )
     */
    public function show(string $id)
    {
        // $Usuaris = Usuaris::find($id);
        // return view('Usuaris.show', ['Usuaris' => $Usuaris]);
        try {
            $tupla = Usuaris::findOrFail($id);
            return response()->json(['status' => 'correcto', 'data' => $tupla], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Usuaris no trobada'], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/Usuariss/{id}",
     *     tags={"Usuaris"},
     *     summary="Actualitza un Usuaris específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Usuaris")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuaris actualitzat correctament"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $tupla = Usuaris::findOrFail($id);
        $reglesValidacio = [
            'nom' => 'required|string|max:255',
            'llinatges' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'mail' => 'required|email|unique:Usuariss,mail|max:255',
            'contrasenya' => 'required|string|min:6',
            'rol' => 'required|in:Usuaris,administrador,gestor',
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
     * @OA\Delete(
     *     path="/api/Usuariss/{id}",
     *     tags={"Usuaris"},
     *     summary="Elimina un Usuaris específic",
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
     *         description="Usuaris eliminat correctament"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $Usuaris = Usuaris::findOrFail($id);
            $Usuaris->update(['data_baixa' => Carbon::now()]);
            return response()->json(['status' => 'success', 'data' => $Usuaris], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
