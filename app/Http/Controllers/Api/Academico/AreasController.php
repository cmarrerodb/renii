<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Areas;
use Illuminate\Http\Request;
class AreasController extends Controller
{
    public function index()
    {
        $areas = Areas::all();
        return response()->json($areas);
    }
    public function show(Areas $area)
    {
        return response()->json($area);
    }
    public function store(Request $request)
    {
        $request->validate([
            'area' => 'required|string|max:150',
        ], [
            'area.required' => 'El campo área es requerido.',
            'area.string' => 'El campo área debe ser una cadena de caracteres.',
            'area.max' => 'El campo área no debe exceder los 150 caracteres.',
        ]);
        $area = Areas::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $area,
        ], 201);
    }
    public function update(Request $request, Areas $area) 
    {
        $request->validate([
            'area' => 'required|string|max:150',
        ], [
            'area.required' => 'El campo área es requerido.',
            'area.string' => 'El campo área debe ser una cadena de caracteres.',
            'area.max' => 'El campo área no debe exceder los 150 caracteres.',
        ]);
        $area->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $area,
        ], 201);
    }
    public function destroy(Areas $area)
    {
        $area->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
