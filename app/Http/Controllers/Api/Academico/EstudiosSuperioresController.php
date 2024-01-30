<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\EstudiosSuperiores;
use Illuminate\Http\Request;
class EstudiosSuperioresController extends Controller
{
    public function index()
    {
        $estudiosSuperiores = EstudiosSuperiores::all();
        return response()->json($estudiosSuperiores);
    }
    public function show(EstudiosSuperiores $estudiosSuperiores)
    {
        return response()->json($estudiosSuperiores);
    }
    public function store(Request $request)
    {
        $request->validate([
            'estudio_superior' => 'required|string|max:150',
            'usuario_creador' => 'required|integer',
        ], [
            'estudio_superior.required' => 'El campo estudio_superior es requerido.',
            'estudio_superior.string' => 'El campo estudio_superior debe ser una cadena de caracteres.',
            'estudio_superior.max' => 'El campo estudio_superior no debe exceder los 150 caracteres.',
            'usuario_creador.required' => 'El campo usuario_creador es requerido.',
            'usuario_creador.integer' => 'El campo usuario_creador debe ser un número entero.',
        ]);
        $estudiosSuperiores = EstudiosSuperiores::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $estudiosSuperiores,
        ], 201);
    }
    public function update(Request $request, EstudiosSuperiores $estudiosSuperiores)
    {
        $request->validate([
            'estudio_superior' => 'required|string|max:150',
            'usuario_creador' => 'required|integer',
        ], [
            'estudio_superior.required' => 'El campo estudio_superior es requerido.',
            'estudio_superior.string' => 'El campo estudio_superior debe ser una cadena de caracteres.',
            'estudio_superior.max' => 'El campo estudio_superior no debe exceder los 150 caracteres.',
            'usuario_creador.required' => 'El campo usuario_creador es requerido.',
            'usuario_creador.integer' => 'El campo usuario_creador debe ser un número entero.',
        ]);
        $estudiosSuperiores->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $estudiosSuperiores,
        ], 201);
    }
    public function destroy(EstudiosSuperiores $estudiosSuperiores)
    {
        $estudiosSuperiores->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
