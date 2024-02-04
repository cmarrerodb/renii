<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\LineasConsejoPresidencial;
use Illuminate\Http\Request;
class LineasConsejoPresidencialController extends Controller
{
    public function index()
    {
        $lineasConsejoPresidencial = LineasConsejoPresidencial::all();
        return response()->json($lineasConsejoPresidencial);
    }
    public function show(Request $request,$id)
    {
        $lineasConsejoPresidencial = LineasConsejoPresidencial::find($id);
        if (!$lineasConsejoPresidencial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }

        $lineasConsejoPresidencial->update($request->all());
        return response()->json([
            'data' => $lineasConsejoPresidencial,
        ], 201);
    }
    public function store(Request $request)
    {
        $request->validate([
            'linea_consejo_presidencial' => 'required|string|max:150',
        ], [
            'linea_consejo_presidencial.required' => 'El campo línea_consejo_presidencial es requerido.',
            'linea_consejo_presidencial.string' => 'El campo línea_consejo_presidencial debe ser una cadena de caracteres.',
            'linea_consejo_presidencial.max' => 'El campo línea_consejo_presidencial no debe exceder los 150 caracteres.',
        ]);

        $lineasConsejoPresidencial = LineasConsejoPresidencial::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $lineasConsejoPresidencial,
        ], 201);
    }
    // public function update(Request $request, LineasConsejoPresidencial $lineasConsejoPresidencial) 
    public function update(Request $request, $id) 
    {
        $request->validate([
            'linea_consejo_presidencial' => 'required|string|max:150',
        ], [
            'linea_consejo_presidencial.required' => 'El campo línea_consejo_presidencial es requerido.',
            'linea_consejo_presidencial.string' => 'El campo línea_consejo_presidencial debe ser una cadena de caracteres.',
            'linea_consejo_presidencial.max' => 'El campo línea_consejo_presidencial no debe exceder los 150 caracteres.',
        ]);
        $lineasConsejoPresidencial = LineasConsejoPresidencial::find($id);
        if (!$lineasConsejoPresidencial) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }
        $lineasConsejoPresidencial->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $lineasConsejoPresidencial,
        ], 201);
    }
    // public function destroy(LineasConsejoPresidencial $lineasConsejoPresidencial)
    public function destroy($id)
    {
        $lineasConsejoPresidencial = LineasConsejoPresidencial::findOrFail($id);
        $lineasConsejoPresidencial->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 201);
    }
}
