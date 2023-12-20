<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Serveis;

class ServeisController extends Controller
{
    /**
     * Muestra una lista de todos los servicios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serveis = Serveis::all();
        return response()->json(['serveis' => $serveis]);
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_serveis' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $servei = Serveis::create($request->all());

        return response()->json(['message' => 'Servicio creado correctamente', 'servei' => $servei]);
    }

    /**
     * Muestra el servicio especificado.
     *
     * @param  \App\Models\Serveis  $servei
     * @return \Illuminate\Http\Response
     */
    public function show(Serveis $servei)
    {
        return response()->json(['servei' => $servei]);
    }

    /**
     * Actualiza el servicio especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servei  $servei
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serveis $servei)
    {
        $request->validate([
            'nom_serveis' => 'required|string|max:255',
            'data_baixa' => 'nullable|date',
        ]);

        $servei->update($request->all());

        return response()->json(['message' => 'Servicio actualizado correctamente', 'servei' => $servei]);
    }

    /**
     * Elimina el servicio especificado de la base de datos.
     *
     * @param  \App\Models\Serveis  $servei
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serveis $servei)
    {
        $servei->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente']);
    }
}
