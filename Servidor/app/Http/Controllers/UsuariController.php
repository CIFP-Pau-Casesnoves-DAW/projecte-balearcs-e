<?php

namespace App\Http\Controllers;

use App\Models\Usuari;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Usuari",
 *     description="Operacions per a Usuaris"
 * )
 */
class UsuariController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/usuaris",
     *     tags={"Usuari"},
     *     summary="Llista tots els usuaris",
     *     @OA\Response(
     *         response=200,
     *         description="Retorna un llistat de tots els usuaris",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Usuari")
     *         )
     *     )
     * )
     */
    public function index()
    {
        // $usuaris = Usuari::paginate(10);
        // return view('usuari.index', ['usuaris' => $usuaris]);
        $tuples = Usuari::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/usuaris",
     *     tags={"Usuari"},
     *     summary="Crea un nou usuari",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Usuari")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuari creat correctament"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/usuaris/{id}",
     *     tags={"Usuari"},
     *     summary="Mostra un usuari específic",
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
     *         description="Retorna l'usuari especificat",
     *         @OA\JsonContent(ref="#/components/schemas/Usuari")
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/usuaris/{id}",
     *     tags={"Usuari"},
     *     summary="Actualitza un usuari específic",
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
     *         @OA\JsonContent(ref="#/components/schemas/Usuari")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuari actualitzat correctament"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/usuaris/{id}",
     *     tags={"Usuari"},
     *     summary="Elimina un usuari específic",
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
     *         description="Usuari eliminat correctament"
     *     )
     * )
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
