<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Subareas;
use Illuminate\Http\Request;
class SubareasController extends Controller
{
    public function index()
    {
        $subareas = Subareas::all();
        return response()->json($subareas);
    }
    public function show(Subareas $subareas)
    {
        return response()->json($subareas);
    }
    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|integer',
            'subarea' => 'required|string|max:150',
        ], [
            'area_id.required' => 'El campo area_id es requerido.',
            'area_id.integer' => 'El campo area_id debe ser un número entero.',
            'subarea.required' => 'El campo subarea es requerido.',
            'subarea.string' => 'El campo subarea debe ser una cadena de caracteres.',
            'subarea.max' => 'El campo subarea no debe exceder los 150 caracteres.',
        ]);
        $subarea = Subareas::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $subarea,
        ], 201);
    }
    public function update(Request $request, Subareas $subareas)
    {
        $request->validate([
            'area_id' => 'required|integer',
            'subarea' => 'required|string|max:150',
        ], [
            'area_id.required' => 'El campo area_id es requerido.',
            'area_id.integer' => 'El campo area_id debe ser un número entero.',
            'subarea.required' => 'El campo subarea es requerido.',
            'subarea.string' => 'El campo subarea debe ser una cadena de caracteres.',
            'subarea.max' => 'El campo subarea no debe exceder los 150 caracteres.',
        ]);
        $subareas->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $subareas,
        ], 201);
    }
    public function destroy(Subareas $subareas)
    {
        $subareas->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}