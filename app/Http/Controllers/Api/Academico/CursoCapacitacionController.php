<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Investigadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class CursoCapacitacionController extends Controller
{
    public function index()
    {
        $cursos = DB::table('vcurso_capacitacion')->get();
        return response()->json($cursos);
    }
    public function show($id)
    {
        $cursos = Cursos::find($id);
        $cursos = DB::table('vcurso_capacitacion')->find($id);
        if (!$cursos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($cursos);
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
        try {
            $cursos = Cursos::create($request->all());
            $cursos->id = $cursos->id;
            return response()->json([
                'message' => 'Registro creado exitosamente',
                'data' => $cursos,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al insertar los datos',
                'error' => $e->getMessage(),
            ], 500);
        }    
    }
    public function update(Request $request, $id)
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
        $cursos = Cursos::find($id);
        if (!$cursos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }
        try {
            $cursos->update($request->all());
            $cursos->id = $cursos->id;
            return response()->json([
                'message' => 'Registro creado exitosamente',
                'data' => $cursos,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al actualizar los datos',
                'error' => $e->getMessage(),
            ], 500);
        }          
    }
    public function destroy($id)
    {
        $cursos = Cursos::find($id);
        if (!$cursos) {
            return response()->json(['message' => 'Registro no encontrado'], 404);   
        }        
        $cursos->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 201);
    }
    public function logged_courses(Request $request) {
        $investigador_id = Investigadores::where('usuario_id', '=', Auth::id())->pluck('id');
        $resultados = DB::table('vcurso_capacitacion')
        ->where('investigador_id', $investigador_id)
        ->get();
        return response()->json(['message' => $resultados], 201);
    }
    public function search_courses_ci(Request $request) {
        $investigador_id = Investigadores::where('cedula', '=', $request->cedula)->pluck('id');    
        if ($investigador_id->isEmpty()) {
            return response()->json(['message' => 'Investigador no registrado'], 404);
        }
        $resultados = DB::table('vcurso_capacitacion')
            ->where('investigador_id', $investigador_id)
            ->get();   
        if ($resultados->isEmpty()) {
            return response()->json(['message' => 'Investigador no tiene cursos registrados'], 404);
        }   
        return response()->json(['message' => $resultados], 201);
    }
}