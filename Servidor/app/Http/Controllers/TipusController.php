<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipus;

class TipusController extends Controller
{
    /**
     * Muestra una lista de todos los tipos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipus = Tipus::all();
        return response()->json(['tipus' => $tipus]);
    }

    /**
     * Almacena un nuevo tipo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_tipus' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $tipus = Tipus::create($request->all());

        return response()->json(['message' => 'Tipo creado correctamente', 'tipus' => $tipus]);
    }

    /**
     * Muestra el tipo especificado.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */
    public function show(Tipus $tipus)
    {
        return response()->json(['tipus' => $tipus]);
    }

    /**
     * Actualiza el tipo especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipus $tipus)
    {
        $request->validate([
            'nom_tipus' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $tipus->update($request->all());

        return response()->json(['message' => 'Tipo actualizado correctamente', 'tipus' => $tipus]);
    }

    /**
     * Elimina el tipo especificado de la base de datos.
     *
     * @param  \App\Models\Tipus  $tipus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipus $tipus)
    {
        $tipus->delete();

        return response()->json(['message' => 'Tipo eliminado correctamente']);
    }
}
