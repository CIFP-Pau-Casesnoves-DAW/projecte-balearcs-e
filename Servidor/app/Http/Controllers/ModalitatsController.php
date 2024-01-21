<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modalitat;
use App\Http\Requests\StoreModalitatRequest;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Modalitat",
 *     description="Operacions per a Modalitats"
 * )
 */
class ModalitatsController extends Controller
{

    /**
 * @OA\Get(
 *     path="/modalitats",
 *     summary="Llista totes les modalitats",
 *     tags={"Modalitat"},
 *     @OA\Response(
 *         response=200,
 *         description="Retorna una llista de totes les modalitats",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="modalitats",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Modalitat")
 *             )
 *         )
 *     )
 * )
 * @OA\Schema(
 *     schema="Modalitat",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nom_modalitat", type="string", example="Pintura"),
 *     @OA\Property(property="descripcio", type="string", example="Pintura sobre tela")
 *      
 * )
 */

    public function index()
    {
        $modalitats = Modalitat::all();
        return response()->json(['modalitats' => $modalitats], 200);
    }


    /**
 * @OA\Post(
 *     path="/modalitats",
 *     summary="Crea una nova modalitat",
 *     tags={"Modalitat"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades necessàries per a la creació d'una nova modalitat",
 *         @OA\JsonContent(
 *             required={"nom_modalitat"},
 *             @OA\Property(property="nom_modalitat", type="string", example="Escultura")
 * 
 *             
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Modalitat creada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat creada amb èxit"),
 *             @OA\Property(property="modalitat", type="object", ref="#/components/schemas/Modalitat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en la creació de la modalitat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Hi ha hagut un error en crear la modalitat")
 *         )
 *     )
 * )
 */
    public function store(StoreModalitatRequest $request)
{
    try {
        $modalitat = Modalitat::create($request->validated());
        return response()->json([
            'message' => 'Modalitat creada amb èxit',
            'modalitat' => $modalitat
        ], 201); // Estat HTTP 201: Creat
    } catch (\Exception $e) {
        return response()->json(['message' => 'Hi ha hagut un error en crear la modalitat'], 500);
    }
}

    /**
 * @OA\Get(
 *     path="/modalitats/{id}",
 *     summary="Obté detalls d'una modalitat específica",
 *     tags={"Modalitat"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Retorna els detalls de la modalitat especificada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="modalitat", type="object", ref="#/components/schemas/Modalitat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     )
 * )
 */

    public function show($id)
    {
        $modalitat = Modalitat::findOrFail($id);
        return response()->json(['modalitat' => $modalitat], 200);
    }

    /**
 * @OA\Put(
 *     path="/modalitats/{id}",
 *     summary="Actualitza una modalitat existent",
 *     tags={"Modalitat"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat a actualitzar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Dades per a actualitzar la modalitat",
 *         @OA\JsonContent(ref="#/components/schemas/StoreModalitatRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat actualitzada amb èxit",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat actualitzada amb èxit"),
 *             @OA\Property(property="modalitat", type="object", ref="#/components/schemas/Modalitat")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en l'actualització de la modalitat",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error en l'actualització de la modalitat")
 *         )
 *     )
 * )
 */

    public function update(StoreModalitatRequest $request, $id)
{
    try {
        $modalitat = Modalitat::findOrFail($id);
        $modalitat->update($request->validated());

        return response()->json([
            'message' => 'Modalitat actualitzada amb èxit',
            'modalitat' => $modalitat
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Modalitat no trobada'], 404);
    } catch (\Exception $e) {
        Log::error('Error actualitzant modalitat: ', ['exception' => $e]);
        return response()->json(['message' => 'Error en l´actualització de la modalitat'], 500);
    }
}

    /**
 * @OA\Delete(
 *     path="/modalitats/{id}",
 *     summary="Elimina una modalitat existent",
 *     tags={"Modalitat"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la modalitat a eliminar",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Modalitat eliminada correctament",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat eliminada correctament")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Modalitat no trobada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Modalitat no trobada")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error desconegut",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error desconegut")
 *         )
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $modalitat = Modalitat::findOrFail($id);
            $modalitat->delete();
            return response()->json(['message' => 'Modalitat eliminada correctament'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error desconegut'], 500);
        }
    }
}
