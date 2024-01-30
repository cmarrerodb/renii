<?php
namespace App\Http\Controllers\API;
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
    public function show(LineasConsejoPresidencial $lineaConsejoPresidencial)
    {
        return response()->json($lineaConsejoPresidencial);
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

        $lineaConsejoPresidencial = LineasConsejoPresidencial::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $lineaConsejoPresidencial,
        ], 201);
    }
    public function update(Request $request, LineasConsejoPresidencial $lineaConsejoPresidencial) 
    {
        $request->validate([
            'linea_consejo_presidencial' => 'required|string|max:150',
        ], [
            'linea_consejo_presidencial.required' => 'El campo línea_consejo_presidencial es requerido.',
            'linea_consejo_presidencial.string' => 'El campo línea_consejo_presidencial debe ser una cadena de caracteres.',
            'linea_consejo_presidencial.max' => 'El campo línea_consejo_presidencial no debe exceder los 150 caracteres.',
        ]);
        $lineaConsejoPresidencial->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $lineaConsejoPresidencial,
        ], 201);
    }
    public function destroy(LineasConsejoPresidencial $lineaConsejoPresidencial)
    {
        $lineaConsejoPresidencial->delete();

        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
