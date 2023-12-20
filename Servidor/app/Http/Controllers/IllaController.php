<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Illa;

class IllaController extends Controller
{
    /**
     * Muestra una lista de todas las islas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $illes = Illa::all();
        return response()->json(['illes' => $illes]);
    }

    /**
     * Almacena una nueva isla en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $illa = Illa::create($request->all());

        return response()->json(['message' => 'Isla creada correctamente', 'illa' => $illa]);
    }

    /**
     * Muestra la isla especificada.
     *
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */
    public function show(Illa $illa)
    {
        return response()->json(['illa' => $illa]);
    }

    /**
     * Actualiza la isla especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Illa $illa)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'zona' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $illa->update($request->all());

        return response()->json(['message' => 'Isla actualizada correctamente', 'illa' => $illa]);
    }

    /**
     * Elimina la isla especificada de la base de datos.
     *
     * @param  \App\Models\Illa  $illa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Illa $illa)
    {
        $illa->delete();

        return response()->json(['message' => 'Isla eliminada correctamente']);
    }
}
