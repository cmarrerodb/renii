<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\PerfilAcademico;
use Illuminate\Http\Request;
class PerfilAcademicoController extends Controller
{
    public function index()
    {
        $perfilAcademico = PerfilAcademico::all();
        return response()->json($perfilAcademico);
    }
    public function show(PerfilAcademico $perfilAcademico)
    {
        return response()->json($perfilAcademico);
    }
    public function store(Request $request)
    {
        $request->validate([
            'investigador_id' => 'required|integer',
            'profesion_id' => 'required|integer',
            'nivel_estudio_id' => 'required|integer',
            'ambito_id' => 'required|integer',
            'area_id' => 'required|integer',
            'subarea_id' => 'required|integer',
            'linea_consejo_presidencial_id' => 'required|integer',
            'motor_agenda_bolivariana_id' => 'required|integer',
            'institucion_educativa' => 'required|string|max:150',
            'titulo_obtenido' => 'nullable|string|max:250',
            'anno_culminacion' => 'nullable|integer',
            'pais_id' => 'nullable|integer',
            'institucion_educativa_id' => 'nullable|integer',
            'estudio_superior_id' => 'nullable|integer',
            'ultimo' => 'required|boolean',
        ], [
            'investigador_id.required' => 'El campo investigador_id es requerido.',
            'investigador_id.integer' => 'El campo investigador_id debe ser un número entero.',
            'profesion_id.required' => 'El campo profesion_id es requerido.',
            'profesion_id.integer' => 'El campo profesion_id debe ser un número entero.',
            'nivel_estudio_id.required' => 'El campo nivel_estudio_id es requerido.',
            'nivel_estudio_id.integer' => 'El campo nivel_estudio_id debe ser un número entero.',
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
            'institucion_educativa.required' => 'El campo institucion_educativa es requerido.',
            'institucion_educativa.string' => 'El campo institucion_educativa debe ser una cadena de caracteres.',
            'institucion_educativa.max' => 'El campo institucion_educativa no debe exceder los 150 caracteres.',
            'titulo_obtenido.string' => 'El campo titulo_obtenido debe ser una cadena de caracteres.',
            'titulo_obtenido.max' => 'El campo titulo_obtenido no debe exceder los 250 caracteres.',
            'anno_culminacion.integer' => 'El campo anno_culminacion debe ser un número entero.',
            'pais_id.integer' => 'El campo pais_id debe ser un número entero.',
            'institucion_educativa_id.integer' => 'El campo institucion_educativa_id debe ser un número entero.',
            'estudio_superior_id.integer' => 'El campo estudio_superior_id debe ser un número entero.',
            'ultimo.required' => 'El campo ultimo es requerido.',
            'ultimo.boolean' => 'El campo ultimo debe ser un valor booleano.',
        ]);
        $perfilAcademico = PerfilAcademico::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $perfilAcademico,
        ], 201);
    }
    public function update(Request $request, PerfilAcademico $perfilAcademico) 
    {
        $request->validate([
            'investigador_id' => 'required|integer',
            'profesion_id' => 'required|integer',
            'nivel_estudio_id' => 'required|integer',
            'ambito_id' => 'required|integer',
            'area_id' => 'required|integer',
            'subarea_id' => 'required|integer',
            'linea_consejo_presidencial_id' => 'required|integer',
            'motor_agenda_bolivariana_id' => 'required|integer',
            'institucion_educativa' => 'required|string|max:150',
            'titulo_obtenido' => 'nullable|string|max:250',
            'anno_culminacion' => 'nullable|integer',
            'pais_id' => 'nullable|integer',
            'institucion_educativa_id' => 'nullable|integer',
            'estudio_superior_id' => 'nullable|integer',
            'ultimo' => 'required|boolean',
        ], [
            'investigador_id.required' => 'El campo investigador_id es requerido.',
            'investigador_id.integer' => 'El campo investigador_id debe ser un número entero.',
            'profesion_id.required' => 'El campo profesion_id es requerido.',
            'profesion_id.integer' => 'El campo profesion_id debe ser un número entero.',
            'nivel_estudio_id.required' => 'El campo nivel_estudio_id es requerido.',
            'nivel_estudio_id.integer' => 'El campo nivel_estudio_id debe ser un número entero.',
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
            'institucion_educativa.required' => 'El campo institucion_educativa es requerido.',
            'institucion_educativa.string' => 'El campo institucion_educativa debe ser una cadena de caracteres.',
            'institucion_educativa.max' => 'El campo institucion_educativa no debe exceder los 150 caracteres.',
            'titulo_obtenido.string' => 'El campo titulo_obtenido debe ser una cadena de caracteres.',
            'titulo_obtenido.max' => 'El campo titulo_obtenido no debe exceder los 250 caracteres.',
            'anno_culminacion.integer' => 'El campo anno_culminacion debe ser un número entero.',
            'pais_id.integer' => 'El campo pais_id debe ser un número entero.',
            'institucion_educativa_id.integer' => 'El campo institucion_educativa_id debe ser un número entero.',
            'estudio_superior_id.integer' => 'El campo estudio_superior_id debe ser un número entero.',
            'ultimo.required' => 'El campo ultimo es requerido.',
            'ultimo.boolean' => 'El campo ultimo debe ser un valor booleano.',
        ]);
        $perfilAcademico->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $perfilAcademico,
        ], 201);
    }
    public function destroy(PerfilAcademico $perfilAcademico)
    {
        $perfilAcademico->delete();   
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}