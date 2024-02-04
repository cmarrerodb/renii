<?php

namespace App\Http\Controllers\API\Academico;

use App\Http\Controllers\Controller;
use App\Models\NivelEstudio;
use Illuminate\Http\Request;

class NivelEstudioController extends Controller
{
    public function index()
    {
        $nivelesEstudio = NivelEstudio::all();
        return response()->json($nivelesEstudio);
    }

    public function show(NivelEstudio $nivelEstudio)
    {
        return response()->json($nivelEstudio);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nivel_estudio' => 'required|string|max:500',
            'orden' => 'required|integer',
        ], [
            'nivel_estudio.required' => 'El campo nivel_estudio es requerido.',
            'nivel_estudio.string' => 'El campo nivel_estudio debe ser una cadena de caracteres.',
            'nivel_estudio.max' => 'El campo nivel_estudio no debe exceder los 500 caracteres.',
            'orden.required' => 'El campo orden es requerido.',
            'orden.integer' => 'El campo orden debe ser un número entero.',
        ]);

        $nivelEstudio = NivelEstudio::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $nivelEstudio,
        ], 201);
    }

    public function update(Request $request, NivelEstudio $nivelEstudio) 
    {
        $request->validate([
            'nivel_estudio' => 'required|string|max:500',
            'orden' => 'required|integer',
        ], [
            'nivel_estudio.required' => 'El campo nivel_estudio es requerido.',
            'nivel_estudio.string' => 'El campo nivel_estudio debe ser una cadena de caracteres.',
            'nivel_estudio.max' => 'El campo nivel_estudio no debe exceder los 500 caracteres.',
            'orden.required' => 'El campo orden es requerido.',
            'orden.integer' => 'El campo orden debe ser un número entero.',
        ]);

        $nivelEstudio->update($request->all());
        
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $nivelEstudio,
        ], 201);
    }

    public function destroy(NivelEstudio $nivelEstudio)
    {
        $nivelEstudio->delete();

        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
