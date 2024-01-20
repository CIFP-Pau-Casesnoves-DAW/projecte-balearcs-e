<?php

namespace App\Http\Controllers;

use App\Models\Comentaris;
use Illuminate\Http\Request;

class ComentarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tuples = Comentaris::all();
        return response()->json(['status' => 'correcto', 'data' => $tuples], 200);
    }

    /**
     * Store a newly created resource in storage.   
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $comentari = Comentaris::findOrFail($id);
            $comentari->delete();
            return response()->json(['status' => 'success', 'data' => $comentari], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'Error'], 400);
        }
    }
}
