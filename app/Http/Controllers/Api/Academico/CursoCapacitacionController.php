<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\CursoCapacitacion;
use Illuminate\Http\Request;
class CursoCapacitacionController extends Controller
{
    public function index()
    {
        $cursosCapacitacion = CursoCapacitacion::all();
        return response()->json($cursosCapacitacion);
    }

    public function show(CursoCapacitacion $cursoCapacitacion)
    {
        return response()->json($cursoCapacitacion);
    }
    public function store(Request $request)
    {
        $request->validate([
            'investigador_id' => 'required|integer',
            'capacitacion_id' => 'required|integer',
            'ambito_id' => 'required|integer',
            'area_id' => 'required|integer',
            'subarea_id' => 'required|integer',
            'linea_consejo_presidencial_id' => 'required|integer',
            'motor_agenda_bolivariana_id' => 'required|integer',
            'pais_id' => 'required|integer',
            'institucion' => 'required|string|max:250',
            'nombre_curso' => 'required|string|max:250',
            'horas_academicas' => 'required|integer',
        ], [
            'investigador_id.required' => 'El campo investigador_id es requerido.',
            'investigador_id.integer' => 'El campo investigador_id debe ser un número entero.',
            'capacitacion_id.required' => 'El campo capacitacion_id es requerido.',
            'capacitacion_id.integer' => 'El campo capacitacion_id debe ser un número entero.',
            'ambito_id.required' => 'El campo ambito_id es requerido.',
            'ambito_id.integer' => 'El campo ambito_id debe ser un número entero.',
            'area_id.required' => 'El campo area_id es requerido.',
            'area_id.integer' => 'El campo area_id debe ser un número entero.',
            'subarea_id.required' => 'El campo subarea_id es requerido.',
            'subarea_id.integer' => 'El campo subarea_id debe ser un número entero.',
            'linea_consejo_presidencial_id.required' => 'El campo linea_consejo_presidencial_id es requerido.',
            'linea_consejo_presidencial_id.integer' => 'El campo linea_consejo_presidencial_id debe ser un número entero.',
            'motor_agenda_bolivariana_id.required' => 'El campo motor_agenda_bolivariana_id es requerido.',
            'motor_agenda_bolivariana_id.integer' => 'El campo motor_agenda_bolivariana_id debe ser un número entero.',
            'pais_id.required' => 'El campo pais_id es requerido.',
            'pais_id.integer' => 'El campo pais_id debe ser un número entero.',
            'institucion.required' => 'El campo institucion es requerido.',
            'institucion.string' => 'El campo institucion debe ser una cadena de caracteres.',
            'institucion.max' => 'El campo institucion no debe exceder los 250 caracteres.',
            'nombre_curso.required' => 'El campo nombre_curso es requerido.',
            'nombre_curso.string' => 'El campo nombre_curso debe ser una cadena de caracteres.',
            'nombre_curso.max' => 'El campo nombre_curso no debe exceder los 250 caracteres.',
            'horas_academicas.required' => 'El campo horas_academicas es requerido.',
            'horas_academicas.integer' => 'El campo horas_academicas debe ser un número entero.',
        ]);
        $cursoCapacitacion = CursoCapacitacion::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $cursoCapacitacion,
        ], 201);
    }
    public function update(Request $request, CursoCapacitacion $cursoCapacitacion)
    {
        $request->validate([
            'investigador_id' => 'required|integer',
            'capacitacion_id' => 'required|integer',
            'ambito_id' => 'required|integer',
            'area_id' => 'required|integer',
            'subarea_id' => 'required|integer',
            'linea_consejo_presidencial_id' => 'required|integer',
            'motor_agenda_bolivariana_id' => 'required|integer',
            'pais_id' => 'required|integer',
            'institucion' => 'required|string|max:250',
            'nombre_curso' => 'required|string|max:250',
            'horas_academicas' => 'required|integer',
        ], [
            'investigador_id.required' => 'El campo investigador_id es requerido.',
            'investigador_id.integer' => 'El campo investigador_id debe ser un número entero.',
            'capacitacion_id.required' => 'El campo capacitacion_id es requerido.',
            'capacitacion_id.integer' => 'El campo capacitacion_id debe ser un número entero.',
            'ambito_id.required' => 'El campo ambito_id es requerido.',
            'ambito_id.integer' => 'El campo ambito_id debe ser un número entero.',
            'area_id.required' => 'El campo area_id es requerido.',
            'area_id.integer' => 'El campo area_id debe ser un número entero.',
            'subarea_id.required' => 'El campo subarea_id es requerido.',
            'subarea_id.integer' => 'El campo subarea_id debe ser un número entero.',
            'linea_consejo_presidencial_id.required' => 'El campo linea_consejo_presidencial_id es requerido.',
            'linea_consejo_presidencial_id.integer' => 'El campo linea_consejo_presidencial_id debe ser un número entero.',
            'motor_agenda_bolivariana_id.required' => 'El campo motor_agenda_bolivariana_id es requerido.',
            'motor_agenda_bolivariana_id.integer' => 'El campo motor_agenda_bolivariana_id debe ser un número entero.',
            'pais_id.required' => 'El campo pais_id es requerido.',
            'pais_id.integer' => 'El campo pais_id debe ser un número entero.',
            'institucion.required' => 'El campo institucion es requerido.',
            'institucion.string' => 'El campo institucion debe ser una cadena de caracteres.',
            'institucion.max' => 'El campo institucion no debe exceder los 250 caracteres.',
            'nombre_curso.required' => 'El campo nombre_curso es requerido.',
            'nombre_curso.string' => 'El campo nombre_curso debe ser una cadena de caracteres.',
            'nombre_curso.max' => 'El campo nombre_curso no debe exceder los 250 caracteres.',
            'horas_academicas.required' => 'El campo horas_academicas es requerido.',
            'horas_academicas.integer' => 'El campo horas_academicas debe ser un número entero.',
        ]);
        $cursoCapacitacion->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $cursoCapacitacion,
        ], 201);
    }
    public function destroy(CursoCapacitacion $cursoCapacitacion)
    {
        $cursoCapacitacion->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}