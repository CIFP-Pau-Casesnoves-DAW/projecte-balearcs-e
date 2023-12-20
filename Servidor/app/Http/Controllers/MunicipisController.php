<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipis;

class MunicipisController extends Controller
{
    public function index()
    {
        $municipis = Municipis::all();
        return response()->json(['municipis' => $municipis]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'illa_id' => 'required|integer',
            'data_baixa' => 'nullable|date',
        ]);

        $municipi = Municipis::create($request->all());

        return response()->json(['message' => 'Municipi creat correctament', 'municipi' => $municipi]);
    }
    public function show(Municipis $municipi)
    {
        return response()->json(['municipi' => $municipi]);
    }
    public function update(Request $request, Municipis $municipi)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'illa_id' => 'required|integer',
            'data_baixa' => 'nullable|date',
        ]);

        $municipi->update($request->all());

        return response()->json(['message' => 'Municipi actualitzat correctament', 'municipi' => $municipi]);
    }
    public function destroy(Municipis $municipi)
    {
        $municipi->delete();
        return response()->json(['message' => 'Municipi eliminat correctament']);
    }
}
