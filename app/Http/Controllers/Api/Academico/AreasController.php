<?php
namespace App\Http\Controllers\API\Academico;
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
    public function show($id)
    {
        $areas = Areas::find($id);
        if (!$areas) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($areas);        
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
    public function update(Request $request, $id) 
    {
        $request->validate([
            'area' => 'required|string|max:150',
        ], [
            'area.required' => 'El campo área es requerido.',
            'area.string' => 'El campo área debe ser una cadena de caracteres.',
            'area.max' => 'El campo área no debe exceder los 150 caracteres.',
        ]);
        $area = Areas::find($id);
        if (!$area) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }        
        $area->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $area,
        ], 201);
    }
    public function destroy($id)
    {
        $area = Areas::find($id);
        if (!$area) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }        
        $area->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 201);
    }
}
