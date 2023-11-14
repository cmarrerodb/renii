<?php

namespace App\Http\Controllers\Api\Geolocalización;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Municipios;
use Illuminate\Http\Response;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }
    public function municipios_estados(Request $request, $estado_id) {
        $municipios = Municipios::with('estado')
            ->where('estado_id', $estado_id)
            ->orderBy('municipio', 'asc')
            ->get(['id', 'cod_municipio', 'municipio']);

        if ($municipios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }

        return response()->json($municipios, 200);
    }      
}
