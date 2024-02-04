<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Paises;
use Illuminate\Http\Request;
class PaisesController extends Controller
{
    public function index()
    {
        $paises = Paises::all();
        return response()->json($paises);
    }
    public function show(Paises $pais)
    {
        return response()->json($pais);
    }
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:2',
            'nombre' => 'required|string|max:80',
            'created_at' => 'required|date',
        ], [
            'codigo.required' => 'El campo código es requerido.',
            'codigo.string' => 'El campo código debe ser una cadena de caracteres.',
            'codigo.max' => 'El campo código no debe exceder los 2 caracteres.',
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El campo nombre no debe exceder los 80 caracteres.',
            'created_at.required' => 'El campo created_at es requerido.',
            'created_at.date' => 'El campo created_at debe ser una fecha válida.',
        ]);
        $pais = Paises::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $pais,
        ], 201);
    }
    public function update(Request $request, Paises $pais) 
    {
        $request->validate([
            'codigo' => 'required|string|max:2',
            'nombre' => 'required|string|max:80',
            'created_at' => 'required|date',
        ], [
            'codigo.required' => 'El campo código es requerido.',
            'codigo.string' => 'El campo código debe ser una cadena de caracteres.',
            'codigo.max' => 'El campo código no debe exceder los 2 caracteres.',
            'nombre.required' => 'El campo nombre es requerido.',
            'nombre.string' => 'El campo nombre debe ser una cadena de caracteres.',
            'nombre.max' => 'El campo nombre no debe exceder los 80 caracteres.',
            'created_at.required' => 'El campo created_at es requerido.',
            'created_at.date' => 'El campo created_at debe ser una fecha válida.',
        ]);
        $pais->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $pais,
        ], 201);
    }
    public function destroy(Paises $pais)
    {
        $pais->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
