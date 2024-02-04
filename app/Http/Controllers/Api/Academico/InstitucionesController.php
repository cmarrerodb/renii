<?php

namespace App\Http\Controllers\API\Academico;

use App\Http\Controllers\Controller;
use App\Models\Instituciones;
use Illuminate\Http\Request;
class InstitucionesController extends Controller
{
    public function index()
    {
        $instituciones = Instituciones::all();
        return response()->json($instituciones);
    }
    public function show(Instituciones $instituciones)
    {
        return response()->json($instituciones);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo_institucion_id' => 'required|integer',
            'nombre_institucion' => 'required|string|max:250',
        ], [
            'tipo_institucion_id.required' => 'El campo tipo_institucion_id es requerido.',
            'tipo_institucion_id.integer' => 'El campo tipo_institucion_id debe ser un número entero.',
            'nombre_institucion.required' => 'El campo nombre_institucion es requerido.',
            'nombre_institucion.string' => 'El campo nombre_institucion debe ser una cadena de caracteres.',
            'nombre_institucion.max' => 'El campo nombre_institucion no debe exceder los 250 caracteres.',
        ]);

        $institucion = Instituciones::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $institucion,
        ], 201);
    }
    public function update(Request $request, Instituciones $instituciones)
    {
        $request->validate([
            'tipo_institucion_id' => 'required|integer',
            'nombre_institucion' => 'required|string|max:250',
        ], [
            'tipo_institucion_id.required' => 'El campo tipo_institucion_id es requerido.',
            'tipo_institucion_id.integer' => 'El campo tipo_institucion_id debe ser un número entero.',
            'nombre_institucion.required' => 'El campo nombre_institucion es requerido.',
            'nombre_institucion.string' => 'El campo nombre_institucion debe ser una cadena de caracteres.',
            'nombre_institucion.max' => 'El campo nombre_institucion no debe exceder los 250 caracteres.',
        ]);
        $instituciones->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $instituciones,
        ], 201);
    }
    public function destroy(Instituciones $instituciones)
    {
        $instituciones->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
