<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\TipoInstitucion;
use Illuminate\Http\Request;
class TipoInstitucionController extends Controller
{
    public function index()
    {
        $tiposInstitucion = TipoInstitucion::all();
        return response()->json($tiposInstitucion);
    }
    public function show(TipoInstitucion $tipoInstitucion)
    {
        return response()->json($tipoInstitucion);
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo_institucion' => 'required|string|max:150',
        ], [
            'tipo_institucion.required' => 'El campo tipo_institucion es requerido.',
            'tipo_institucion.string' => 'El campo tipo_institucion debe ser una cadena de caracteres.',
            'tipo_institucion.max' => 'El campo tipo_institucion no debe exceder los 150 caracteres.',
        ]);
        $tipoInstitucion = TipoInstitucion::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $tipoInstitucion,
        ], 201);
    }
    public function update(Request $request, TipoInstitucion $tipoInstitucion) 
    {
        $request->validate([
            'tipo_institucion' => 'required|string|max:150',
        ], [
            'tipo_institucion.required' => 'El campo tipo_institucion es requerido.',
            'tipo_institucion.string' => 'El campo tipo_institucion debe ser una cadena de caracteres.',
            'tipo_institucion.max' => 'El campo tipo_institucion no debe exceder los 150 caracteres.',
        ]);
        $tipoInstitucion->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $tipoInstitucion,
        ], 201);
    }
    public function destroy(TipoInstitucion $tipoInstitucion)
    {
        $tipoInstitucion->delete();

        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}
