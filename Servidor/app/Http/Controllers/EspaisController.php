<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espai;
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
 *     path="/espais",
 *     summary="Llista tots els espais",
 *     tags={"Espais"},
 *     @OA\Response(
 *         response=200,
 *         description="Operació exitosa, retorna una llista d'espais",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="correcto"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Espai")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error de validació",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 additionalProperties={
 *                     @OA\Schema(type="array", @OA\Items(type="string"))
 *                 }
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Espai",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom", type="string", example="Museu d'Art Modern"),
 *     @OA\Property(property="descripcio", type="string", example="Museu dedicat a l'art del segle XX"),
 *     @OA\Property(property="carrer", type="string", example="Carrer de l'Exemple"),
 *     @OA\Property(property="numero", type="string", example="123"),
 *     @OA\Property(property="pis_porta", type="string", example="2n 1a", nullable=true),
 *     @OA\Property(property="web", type="string", example="https://www.exemple.com", nullable=true),
 *     @OA\Property(property="mail", type="string", format="email", example="contacte@exemple.com"),
 *     @OA\Property(property="grau_acc", type="string", example="alt", nullable=true),
 *     @OA\Property(property="arquitecte_id", type="integer", example=1),
 *     @OA\Property(property="gestor_id", type="integer", example=2),
 *     @OA\Property(property="tipus_id", type="integer", example=3),
 *     @OA\Property(property="municipi_id", type="integer", example=4),
 *     @OA\Property(property="destacat", type="boolean", example=false, nullable=true),
 *     @OA\Property(property="any_cons", type="integer", example=1990, nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T00:00:00Z", nullable=true)
 * )
 */
    public function index()
    {
        try {
            $tuples = Espai::all();
            return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'data' => $e->errors()], 400);
        }
    }



   /**
 * @OA\Post(
 *     path="/espais",
 *     summary="Crea un nou espai",
 *     tags={"Espais"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"nom", "descripcio", "carrer", "numero", "mail", "arquitecte_id", "gestor_id", "tipus_id", "municipi_id"},
 *             @OA\Property(property="nom", type="string", example="Museu d'Art Modern"),
 *             @OA\Property(property="descripcio", type="string", example="Museu dedicat a l'art del segle XX"),
 *             @OA\Property(property="carrer", type="string", example="Carrer de l'Exemple"),
 *             @OA\Property(property="numero", type="string", example="123"),
 *             @OA\Property(property="pis_porta", type="string", example="2n 1a", nullable=true),
 *             @OA\Property(property="web", type="string", example="https://www.exemple.com", nullable=true),
 *             @OA\Property(property="mail", type="string", format="email", example="contacte@exemple.com"),
 *             @OA\Property(property="grau_acc", type="string", example="alt", nullable=true),
 *             @OA\Property(property="arquitecte_id", type="integer", example=1),
 *             @OA\Property(property="gestor_id", type="integer", example=2),
 *             @OA\Property(property="tipus_id", type="integer", example=3),
 *             @OA\Property(property="municipi_id", type="integer", example=4),
 *             @OA\Property(property="destacat", type="boolean", example=false, nullable=true),
 *             @OA\Property(property="any_cons", type="integer", example=1990, nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Espai creat correctament",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="correcte"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espai")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
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
 *     path="/espais/{id}",
 *     summary="Obté un espai per ID",
 *     tags={"Espais"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai a recuperar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Espai trobat amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="correcto"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espai")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Espai no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Espai no trobat")
 *         )
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
 *     path="/espais/{id}",
 *     summary="Actualitza un espai existent",
 *     tags={"Espais"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={},
 *             @OA\Property(property="nom", type="string", example="Museu d'Art Contemporani"),
 *             @OA\Property(property="descripcio", type="string", example="Museu dedicat a l'art contemporani"),
 *             @OA\Property(property="arquitecte_id", type="integer", example=1, nullable=true),
 *             @OA\Property(property="gestor_id", type="integer", example=2, nullable=true),
 *             @OA\Property(property="tipus_id", type="integer", example=3, nullable=true),
 *             @OA\Property(property="municipi_id", type="integer", example=4, nullable=true),
 *             @OA\Property(property="destacat", type="boolean", example=false, nullable=true),
 *             @OA\Property(property="any_cons", type="integer", example=1990, nullable=true)
 * 
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Espai actualitzat amb èxit",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espai")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validació de dades",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="data", type="object")
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
 *     path="/espais/{id}",
 *     summary="Marca un espai com a donat de baixa",
 *     tags={"Espais"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de l'espai a donar de baixa",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Espai marcat com a donat de baixa amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="data", type="object", ref="#/components/schemas/Espai")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error, espai no trobat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="Error")
 *         )
 *     )
 * )
 */
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
