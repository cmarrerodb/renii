<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Profesiones;
use Illuminate\Http\Request;
class ProfesionesController extends Controller
{
    public function index()
    {
        $profesiones = Profesiones::all();
        return response()->json($profesiones);
    }
    public function show(Profesiones $profesion)
    {
        return response()->json($profesion);
    }
    public function store(Request $request)
    {
        $request->validate([
            'profesion' => 'required|string|max:150',
        ], [
            'profesion.required' => 'El campo profesion es requerido.',
            'profesion.string' => 'El campo profesion debe ser una cadena de caracteres.',
            'profesion.max' => 'El campo profesion no debe exceder los 150 caracteres.',
        ]);
        $profesion = Profesiones::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $profesion,
        ], 201);
    }
    public function update(Request $request, Profesiones $profesion) 
    {
        $request->validate([
            'profesion' => 'required|string|max:150',
        ], [
            'profesion.required' => 'El campo profesion es requerido.',
            'profesion.string' => 'El campo profesion debe ser una cadena de caracteres.',
            'profesion.max' => 'El campo profesion no debe exceder los 150 caracteres.',
        ]);
        $profesion->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $profesion,
        ], 201);
    }
    public function destroy(Profesiones $profesion)
    {
        $profesion->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
