<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valoracio;
use App\Models\Valoracions;

class ValoracionsController extends Controller
{
    /**
     * Muestra una lista de todas las valoraciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $valoracions = Valoracions::all();
        return response()->json(['valoracions' => $valoracions]);
    }

    /**
     * Almacena una nueva valoración en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'puntuacio' => 'required|integer',
            'data' => 'required|date',
            'usuari_id' => 'required|exists:usuaris,id',
            'espai_id' => 'required|exists:espais,id',
            'data_baixa' => 'nullable|date',
        ]);

        $valoracio = Valoracions::create($request->all());

        return response()->json(['message' => 'Valoración creada correctamente', 'valoracio' => $valoracio]);
    }

    /**
     * Muestra la valoración especificada.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */
    public function show(Valoracions $valoracio)
    {
        return response()->json(['valoracio' => $valoracio]);
    }

    /**
     * Actualiza la valoración especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valoracions $valoracio)
    {
        $request->validate([
            'puntuacio' => 'required|integer',
            'data' => 'required|date',
            'usuari_id' => 'required|exists:usuaris,id',
            'espai_id' => 'required|exists:espais,id',
            'data_baixa' => 'nullable|date',
        ]);

        $valoracio->update($request->all());

        return response()->json(['message' => 'Valoración actualizada correctamente', 'valoracio' => $valoracio]);
    }

    /**
     * Elimina la valoración especificada de la base de datos.
     *
     * @param  \App\Models\Valoracions  $valoracio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valoracions $valoracio)
    {
        $valoracio->delete();

        return response()->json(['message' => 'Valoración eliminada correctamente']);
    }
}
