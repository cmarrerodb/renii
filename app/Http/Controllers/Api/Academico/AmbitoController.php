<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Ambito;
use Illuminate\Http\Request;
class AmbitoController extends Controller
{
    public function index()
    {
        $ambitos = Ambito::all();
        return response()->json($ambitos);
    }
    public function show($id)
    {
        $ambito = Ambito::find($id);
        if (!$ambito) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
    
        }
        return response()->json($ambito);        
    }
    public function store(Request $request)
    {
        $request->validate([
            'ambito' => 'required|string|max:150',
        ], [
            'ambito.required' => 'El campo ámbito es requerido.',
            'ambito.string' => 'El campo ámbito debe ser una cadena de caracteres.',
            'ambito.max' => 'El campo ámbito no debe exceder los 150 caracteres.',
        ]);

        $ambito = Ambito::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $ambito,
        ], 201);
    }
    public function update(Request $request, $id) 
    {
        $request->validate([
            'ambito' => 'required|string|max:150',
        ], [
            'ambito.required' => 'El campo ámbito es requerido.',
            'ambito.string' => 'El campo ámbito debe ser una cadena de caracteres.',
            'ambito.max' => 'El campo ámbito no debe exceder los 150 caracteres.',
        ]);
        $ambito = Ambito::find($id);
        if (!$ambito) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }
        $ambito->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $ambito,
        ], 201);
    }
    public function destroy($id)
    {
        $nivelEstudio = Ambito::find($id);
        $nivelEstudio->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 201);
    }    
}
