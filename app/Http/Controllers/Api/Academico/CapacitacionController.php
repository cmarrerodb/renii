<?php

namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Capacitacion;
use Illuminate\Http\Request;
class CapacitacionController extends Controller
{
    public function index()
    {
        $capacitaciones = Capacitacion::all();
        return response()->json($capacitaciones);
    }
    public function show($id)
    {
        $capacitacion = Capacitacion::find($id);
        if (!$capacitacion) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($capacitacion);
    }
    public function store(Request $request)
    {
        $request->validate([
            'capacitacion' => 'required|string|max:150',
        ], [
            'capacitacion.required' => 'El campo capacitacion es requerido.',
            'capacitacion.string' => 'El campo capacitacion debe ser una cadena de caracteres.',
            'capacitacion.max' => 'El campo capacitacion no debe exceder los 150 caracteres.',
        ]);
        $capacitacion = Capacitacion::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $capacitacion,
        ], 201);
    }
    public function update(Request $request, $id) 
    {
        $request->validate([
            'capacitacion' => 'required|string|max:150',
            // 'created_at' => 'required|date',
        ], [
            'capacitacion.required' => 'El campo capacitacion es requerido.',
            'capacitacion.string' => 'El campo capacitacion debe ser una cadena de caracteres.',
            'capacitacion.max' => 'El campo capacitacion no debe exceder los 150 caracteres.',
            // 'created_at.required' => 'El campo created_at es requerido.',
            // 'created_at.date' => 'El campo created_at debe ser una fecha válida.',
        ]);
        $capacitacion = Capacitacion::find($id);
        if (!$capacitacion) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $capacitacion->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $capacitacion,
        ], 201);
    }
    public function destroy(Capacitacion $capacitacion)
    {
        $capacitacion->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
