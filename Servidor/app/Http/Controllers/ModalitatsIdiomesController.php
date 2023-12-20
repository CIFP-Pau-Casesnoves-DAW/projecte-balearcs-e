<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModalitatsIdiomes;

class ModalitatsIdiomesController extends Controller
{
    public function index()
    {
        $modalitats_idiomes = ModalitatsIdiomes::all();
        return response()->json(['modalitats_idiomes' => $modalitats_idiomes]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'idioma_id' => 'required|string|max:2',
            'modalitat_id' => 'required|string|max:2',
            'traduccio' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $modalitat_idioma = ModalitatsIdiomes::create($request->all());

        return response()->json(['message' => 'Modalitat-idioma creada correctamente', 'modalitat_idioma' => $modalitat_idioma]);
    }

    public function show(ModalitatsIdiomes $modalitat_idioma)
    {
        return response()->json(['modalitat_idioma' => $modalitat_idioma]);
    }

    public function update(Request $request, ModalitatsIdiomes $modalitat_idioma)
    {
        $request->validate([
            'idioma_id' => 'required|string|max:2',
            'modalitat_id' => 'required|string|max:2',
            'traduccio' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $modalitat_idioma->update($request->all());

        return response()->json(['message' => 'Modalitat-idioma actualitzada correctament', 'modalitat_idioma' => $modalitat_idioma]);
    }

    public function destroy(ModalitatsIdiomes $modalitat_idioma)
    {
        $modalitat_idioma->delete();
        return response()->json(['message' => 'Modalitat-idioma eliminada correctamente']);
    }
}
