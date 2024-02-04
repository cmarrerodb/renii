<?php

namespace App\Http\Controllers\Api\Academico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NivelEstudio;

class NivelEstudioController extends Controller
{
    /**
     * Mostrar todos los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nivelEstudios = NivelEstudio::all();
        return response()->json($nivelEstudios);
    }

    /**
     * Mostrar un registro específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nivelEstudio = NivelEstudio::findOrFail($id);
        return response()->json($nivelEstudio);
    }

    /**
     * Almacenar un nuevo registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nivel_estudio' => 'required|string|max:500',
            'orden' => 'required|integer|unique:nivel_estudio',
        ], [
            'nivel_estudio.required' => 'El campo nivel_estudio es requerido.',
            'nivel_estudio.string' => 'El campo nivel_estudio debe ser una cadena de caracteres.',
            'nivel_estudio.max' => 'El campo nivel_estudio no debe exceder los 500 caracteres.',
            'orden.required' => 'El campo orden es requerido.',
            'orden.integer' => 'El campo orden debe ser un número entero.',
            'orden.unique' => 'El campo orden debe ser único.',
        ]);
        $nivelEstudio = NivelEstudio::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $nivelEstudio,
        ], 201);
    }
    

    /**
     * Actualizar un registro existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nivel_estudio' => 'required|string|max:500',
            'orden' => 'required|integer|unique:nivel_estudio,orden,'.$id,
        ], [
            'nivel_estudio.required' => 'El campo nivel_estudio es requerido.',
            'nivel_estudio.string' => 'El campo nivel_estudio debe ser una cadena de caracteres.',
            'nivel_estudio.max' => 'El campo nivel_estudio no debe exceder los 500 caracteres.',
            'orden.required' => 'El campo orden es requerido.',
            'orden.integer' => 'El campo orden debe ser un número entero.',
            'orden.unique' => 'El campo orden debe ser único.',
        ]);
        $nivelEstudio = NivelEstudio::find($id);
        if (!$nivelEstudio) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }
        $nivelEstudio->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $nivelEstudio,
        ], 201);
    }
    

    /**
     * Eliminar un registro con SoftDeletes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nivelEstudio = NivelEstudio::findOrFail($id);
        $nivelEstudio->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 201);
    }
}
