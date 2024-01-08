<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espai;
use Illuminate\Support\Facades\Validator;

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
        $espais = Espai::all();
        return response()->json(['espais' => $espais], 200);
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
        // Defineix les regles de validació
        $reglesValidacio = [
            'nom' => 'required|string|max:255',
            'descripcio' => 'required|string',
            'carrer' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'pis_porta' => 'nullable|string|max:50',
            'web' => 'nullable|url|max:255',
            'mail' => 'required|email|max:255',
            'grau_acc' => 'nullable|in:baix,mig,alt',
            'data_baixa' => 'nullable|date',
            'arquitecte_id' => 'required|exists:arquitectes,id',
            'gestor_id' => 'required|exists:usuaris,id',
            'tipus_id' => 'required|exists:tipus,id',
            'municipi_id' => 'required|exists:municipis,id',
        ];
    
        // Realitza la validació
        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }
    
        // Crea l'espai
        $espai = Espai::create($request->all());
        return response()->json(['espai' => $espai], 200);
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
        $espai = Espai::findOrFail($id);
        return response()->json(['espai' => $espai], 200);
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
        // Defineix les regles de validació
        $reglesValidacio = [
            'nom' => 'sometimes|required|string|max:255',
            'descripcio' => 'sometimes|required|string',
            'carrer' => 'sometimes|required|string|max:255',
            'numero' => 'sometimes|required|string|max:10',
            'pis_porta' => 'nullable|string|max:50',
            'web' => 'nullable|url|max:255',
            'mail' => 'sometimes|required|email|max:255',
            'grau_acc' => 'nullable|in:baix,mig,alt',
            'data_baixa' => 'nullable|date',
            'arquitecte_id' => 'sometimes|required|exists:arquitectes,id',
            'gestor_id' => 'sometimes|required|exists:usuaris,id',
            'tipus_id' => 'sometimes|required|exists:tipus,id',
            'municipi_id' => 'sometimes|required|exists:municipis,id',
        ];
    
        // Realitza la validació
        $validacio = Validator::make($request->all(), $reglesValidacio);
        if ($validacio->fails()) {
            return response()->json(['errors' => $validacio->errors()], 400);
        }
    
        // Troba i actualitza l'espai
        $espai = Espai::findOrFail($id);
        $espai->update($request->all());
        return response()->json(['espai' => $espai], 200);
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
        $espai = Espai::findOrFail($id);
        $espai->delete();
        return response()->json(['message' => 'Espai eliminat correctament'], 200);
    }
}
