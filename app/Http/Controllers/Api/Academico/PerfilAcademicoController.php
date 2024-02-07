<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\Investigadores;
use App\Models\PerfilAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class PerfilAcademicoController extends Controller
{
    public function index()
    {
        $perfilAcademico = DB::table('vperfil_academico')->get();
        return response()->json($perfilAcademico);
    }

    public function show($id)
    {
        $perfilAcademico = DB::table('vperfil_academico')->find($id);
        if (!$perfilAcademico) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
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
        try {
            $perfilAcademico = PerfilAcademico::create($request->all());
            $perfilAcademico->id = $perfilAcademico->id;
            return response()->json([
                'message' => 'Registro creado exitosamente',
                'data' => $perfilAcademico,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al insertar los datos',
                'error' => $e->getMessage(),
            ], 500);
        }    
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $perfilAcademico,
        ], 201);
    }
    public function update(Request $request, $id) 
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
        $perfilAcademico = PerfilAcademico::find($id);
        if (!$perfilAcademico) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        try {
            $perfilAcademico->update($request->all());
            $perfilAcademico->id = $perfilAcademico->id;
            return response()->json([
                'message' => 'Registro actualizado exitosamente',
                'data' => $perfilAcademico,
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
        $perfilAcademico = PerfilAcademico::find($id);
        if (!$perfilAcademico) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        $perfilAcademico->delete();   
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 201);
    }
    public function logged_academic(Request $request) {
        $investigador_id = Investigadores::where('usuario_id', '=', Auth::id())->pluck('id');
        $resultados = DB::table('vperfil_academico')
        ->where('investigador_id', $investigador_id)
        ->get();
        return response()->json(['message' => $resultados], 201);
    }
    public function search_academic_ci(Request $request) {
        $investigador_id = Investigadores::where('cedula', '=', $request->cedula)->pluck('id');    
        if ($investigador_id->isEmpty()) {
            return response()->json(['message' => 'Investigador no registrado'], 404);
        }
        $resultados = DB::table('vperfil_academico')
            ->where('investigador_id', $investigador_id)
            ->get();   
        if ($resultados->isEmpty()) {
            return response()->json(['message' => 'Investigador no tiene cursos registrados'], 404);
        }   
        return response()->json(['message' => $resultados], 201);
    }    
}