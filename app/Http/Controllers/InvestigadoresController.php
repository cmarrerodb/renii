<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Investigadores;
use App\Models\InvestigadorAuxiliar;
use App\Models\Nacionalidad;
use App\Models\Sexo;
use App\Models\EstadoCivil;
use App\Models\Estados;
use App\Models\Municipios;
use App\Models\Parroquias;
use App\Models\CodigosPostales;
use App\Models\PueblosIndigenas;
use App\Models\TiempoDedicacion;
use App\Models\TipoDedicacion;
use App\Models\OrganizacionesSociales;
use Goutte\Client;
class InvestigadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        ini_set('memory_limit', '256M');
        $perfil_investigador = DB::table('vperfil_inicial')->orderBy('cedula')->get();
        return response()->json($perfil_investigador);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Auth::id();
        $email = Auth::user()->email;            
        $validator = Validator::make($request->all(), [
            'nacionalidad_id' => 'required|integer',
            'cedula' => 'required|integer|unique:investigadores',
            'pasaporte' => 'nullable|min:3|max:50',
            'primer_nombre' => 'required|min:2|max:150',
            'segundo_nombre' => 'nullable|min:2|max:150',
            'primer_apellido' => 'required|min:2|max:150',
            'segundo_apellido' => 'required|min:2|max:150',
            'sexo_id' => 'required|integer',
            'fecha_nacimiento' => 'required|date|date_format:Y-m-d',
            'estado_civil_id' => 'required|integer',
            'pueblo_id' => 'nullable|integer',
            'estado_id' => 'required|integer',
            'municipio_id' => 'required|integer',
            'parroquia_id' => 'required|integer',
            'codigo_postal_id' => 'required|integer',
            'codigo_area' => 'nullable|string|size:4',
            'telefono' => 'nullable|string|size:7|required_with:codigo_area',
            'operadora' => 'nullable|string|size:4',
            'celular' => 'nullable|string|size:7|required_with:operadora',
            'tipo_investigador_id' => 'nullable|integer',
            'tiempo_investigador_id' => 'nullable|integer',
            'organizacion_social_id' => 'nullable|integer',
            'email' => 'required|email|unique:investigadores',
        ], [
            'nacionalidad_id.required' => 'El campo nacionalidad es requerido.',
            'nacionalidad_id.integer' => 'El campo nacionalidad debe ser un número entero.',
            'cedula.required' => 'El campo cédula es requerido.',
            'cedula.integer' => 'El campo cédula debe ser un número entero.',
            'cedula.unique' => 'La cédula ingresada ya existe en la tabla de investigadores.',
            'primer_nombre.required' => 'El campo primer nombre es requerido.',
            'primer_nombre.min' => 'El campo primer nombre debe tener al menos 2 caracteres.',
            'primer_nombre.max' => 'El campo primer nombre no puede tener más de 150 caracteres.',
            'segundo_nombre.min' => 'El campo segundo nombre debe tener al menos 2 caracteres.',
            'segundo_nombre.max' => 'El campo segundo nombre no puede tener más de 150 caracteres.',
            'primer_apellido.required' => 'El campo primer apellido es requerido.',
            'primer_apellido.min' => 'El campo primer apellido debe tener al menos 2 caracteres.',
            'primer_apellido.max' => 'El campo primer apellido no puede tener más de 150 caracteres.',
            'segundo_apellido.required' => 'El campo segundo apellido es requerido.',
            'segundo_apellido.min' => 'El campo segundo apellido debe tener al menos 2 caracteres.',
            'segundo_apellido.max' => 'El campo segundo apellido no puede tener más de 150 caracteres.',
            'sexo_id.required' => 'El campo sexo es requerido.',
            'sexo_id.integer' => 'El campo sexo debe ser un número entero.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es requerido.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.date_format' => 'El campo fecha de nacimiento debe tener el formato YYYY-MM-DD.',
            'estado_civil_id.required' => 'El campo estado civil es requerido.',
            'estado_civil_id.integer' => 'El campo estado civil debe ser un número entero.',            
            'pueblo_indigena_id.integer' => 'El campo pueblo indígena debe ser un número entero.',
            'estado_id.required' => 'El campo estado es requerido.',
            'estado_id.integer' => 'El campo estado debe ser un número entero.',                        
            'municipio_id.required' => 'El campo municipio es requerido.',
            'municipio_id.integer' => 'El campo municipio debe ser un número entero.', 
            'parroquia_id.required' => 'El campo parroquia es requerido.',
            'parroquia_id.integer' => 'El campo parroquia debe ser un número entero.', 
            'codigo_postal_id.required' => 'El campo código postal es requerido.',
            'codigo_postal_id.integer' => 'El campo código postal debe ser un número entero.', 
            'codigo_area.size' => 'El campo código de área debe tener una longitud de 4 caracteres.',
            'telefono.required_with' => 'El campo teléfono es requerido cuando se proporciona el código de área.',
            'telefono.size' => 'El campo teléfono debe tener una longitud de 7 caracteres.',
            'operadora.size' => 'El campo operadora debe tener una longitud de 4 caracteres.',
            'celular.required_with' => 'El campo celular es requerido cuando se proporciona la operadora.',
            'celular.size' => 'El campo celular debe tener una longitud de 7 caracteres.',
            'tipo_investigador_id.integer' => 'El campo tipo de investigador debe ser un número entero.',            
            'tiempo_investigador_id.integer' => 'El campo tiempo dedicación debe ser un número entero.',            
            'organizacion_social_id.integer' => 'El campo organización social debe ser un número entero.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.unique' => 'El campo email ya ha sido registrado.',                        
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $investigadorId = DB::table('investigadores')->insertGetId([
                'nacionalidad_id' => $request->nacionalidad_id,
                'cedula' => $request->cedula,
                'pasaporte' => $request->pasaporte,
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'sexo_id' => $request->sexo_id,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'estado_civil_id' => $request->estado_civil_id,
                'estado_id' => $request->estado_id,
                'municipio_id' => $request->municipio_id,
                'parroquia_id' => $request->parroquia_id,
                'codigo_postal_id' => $request->codigo_postal_id,
                'cod_area_local' => $request->codigo_area,
                'telefono_local' => $request->telefono,
                'cod_operadora_movil' => $request->operadora,
                'celular' => $request->celular,
                'email' => Auth::user()->email,
                'usuario_id' => Auth::id(),
            ]);
            if ($request->pueblo_indigena_id !== null || 
                $request->tipo_dedicacion_id !== null || 
                $request->tiempo_dedicacion_id !== null || 
                $request->organizacion_social_id !== null) {
                DB::table('investigador_auxiliar')->insert([
                    'investigador_id' => $investigadorId,
                    'pueblo_indigena_id' => $request->pueblo_indigena_id,
                    'tipo_dedicacion_id' => $request->tipo_dedicacion_id,
                    'tiempo_dedicacion_id' => $request->tiempo_dedicacion_id,
                    'organizacion_social_id' => $request->organizacion_social_id,
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => 'Datos insertados correctamente',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Error al insertar los datos',
                'error' => $e->getMessage(),
            ], 500);
        }        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nacionalidad_id' => 'sometimes|required|integer',
            'cedula' => [
                'sometimes',
                'required',
                'integer',
                Rule::unique('investigadores')->ignore($id),
            ],
            'pasaporte' => 'nullable|min:3|max:50',
            'primer_nombre' => 'sometimes|required|min:2|max:150',
            'segundo_nombre' => 'nullable|min:2|max:150',
            'primer_apellido' => 'sometimes|required|min:2|max:150',
            'segundo_apellido' => 'sometimes|required|min:2|max:150',
            'sexo_id' => 'sometimes|required|integer',
            'fecha_nacimiento' => 'sometimes|required|date|date_format:Y-m-d',
            'estado_civil_id' => 'sometimes|required|integer',
            'pueblo_id' => 'nullable|integer',
            'estado_id' => 'sometimes|required|integer',
            'municipio_id' => 'sometimes|required|integer',
            'parroquia_id' => 'sometimes|required|integer',
            'codigo_postal_id' => 'sometimes|required|integer',
            'codigo_area' => 'nullable|string|size:4',
            'telefono' => 'nullable|string|size:7|required_with:codigo_area',
            'operadora' => 'nullable|string|size:4',
            'celular' => 'nullable|string|size:7|required_with:operadora',
            'tipo_investigador_id' => 'nullable|integer',
            'tiempo_investigador_id' => 'nullable|integer',
            'organizacion_social_id' => 'nullable|integer',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('investigadores')->ignore($id),
            ],
        ], [
            'nacionalidad_id.required' => 'El campo nacionalidad es requerido.',
            'nacionalidad_id.integer' => 'El campo nacionalidad debe ser un número entero.',
            'cedula.required' => 'El campo cédula es requerido.',
            'cedula.integer' => 'El campo cédula debe ser un número entero.',
            'cedula.unique' => 'La cédula ingresada ya existe en la tabla de investigadores.',
            'primer_nombre.required' => 'El campo primer nombre es requerido.',
            'primer_nombre.min' => 'El campo primer nombre debe tener al menos 2 caracteres.',
            'primer_nombre.max' => 'El campo primer nombre no puede tener más de 150 caracteres.',
            'segundo_nombre.min' => 'El campo segundo nombre debe tener al menos 2 caracteres.',
            'segundo_nombre.max' => 'El campo segundo nombre no puede tener más de 150 caracteres.',
            'primer_apellido.required' => 'El campo primer apellido es requerido.',
            'primer_apellido.min' => 'El campo primer apellido debe tener al menos 2 caracteres.',
            'primer_apellido.max' => 'El campo primer apellido no puede tener más de 150 caracteres.',
            'segundo_apellido.required' => 'El campo segundo apellido es requerido.',
            'segundo_apellido.min' => 'El campo segundo apellido debe tener al menos 2 caracteres.',
            'segundo_apellido.max' => 'El campo segundo apellido no puede tener más de 150 caracteres.',
            'sexo_id.required' => 'El campo sexo es requerido.',
            'sexo_id.integer' => 'El campo sexo debe ser un número entero.',
            'fecha_nacimiento.required' => 'El campo fecha de nacimiento es requerido.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.date_format' => 'El campo fecha de nacimiento debe tener el formato YYYY-MM-DD.',
            'estado_civil_id.required' => 'El campo estado civil es requerido.',
            'estado_civil_id.integer' => 'El campo estado civil debe ser un número entero.',            
            'pueblo_indigena_id.integer' => 'El campo pueblo indígena debe ser un número entero.',
            'estado_id.required' => 'El campo estado es requerido.',
            'estado_id.integer' => 'El campo estado debe ser un número entero.',                        
            'municipio_id.required' => 'El campo municipio es requerido.',
            'municipio_id.integer' => 'El campo municipio debe ser un número entero.', 
            'parroquia_id.required' => 'El campo parroquia es requerido.',
            'parroquia_id.integer' => 'El campo parroquia debe ser un número entero.', 
            'codigo_postal_id.required' => 'El campo código postal es requerido.',
            'codigo_postal_id.integer' => 'El campo código postal debe ser un número entero.', 
            'codigo_area.size' => 'El campo código de área debe tener una longitud de 4 caracteres.',
            'telefono.required_with' => 'El campo teléfono es requerido cuando se proporciona el código de área.',
            'telefono.size' => 'El campo teléfono debe tener una longitud de 7 caracteres.',
            'operadora.size' => 'El campo operadora debe tener una longitud de 4 caracteres.',
            'celular.required_with' => 'El campo celular es requerido cuando se proporciona la operadora.',
            'celular.size' => 'El campo celular debe tener una longitud de 7 caracteres.',
            'tipo_investigador_id.integer' => 'El campo tipo de investigador debe ser un número entero.',            
            'tiempo_investigador_id.integer' => 'El campo tiempo dedicación debe ser un número entero.',            
            'organizacion_social_id.integer' => 'El campo organización social debe ser un número entero.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.unique' => 'El campo email ya ha sido registrado.',                        
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $investigador = Investigadores::findOrFail($id);
            $investigador->nacionalidad_id = $request->nacionalidad_id ?? $investigador->nacionalidad_id;
            $investigador->cedula = $request->cedula ?? $investigador->cedula;
            $investigador->pasaporte = $request->pasaporte;
            $investigador->primer_nombre = $request->primer_nombre ?? $investigador->primer_nombre;
            $investigador->segundo_nombre = $request->segundo_nombre;
            $investigador->primer_apellido = $request->primer_apellido ?? $investigador->primer_apellido;
            $investigador->segundo_apellido = $request->segundo_apellido ?? $investigador->segundo_apellido;
            $investigador->sexo_id = $request->sexo_id ?? $investigador->sexo_id;
            $investigador->fecha_nacimiento = $request->fecha_nacimiento ?? $investigador->fecha_nacimiento;
            $investigador->estado_civil_id = $request->estado_civil_id ?? $investigador->estado_civil_id;
            $investigador->estado_id = $request->estado_id ?? $investigador->estado_id;
            $investigador->municipio_id = $request->municipio_id ?? $investigador->municipio_id;
            $investigador->parroquia_id = $request->parroquia_id ?? $investigador->parroquia_id;
            $investigador->codigo_postal_id = $request->codigo_postal_id ?? $investigador->codigo_postal_id;
            $investigador->cod_area_local = $request->codigo_area;
            $investigador->telefono_local = $request->telefono;
            $investigador->cod_operadora_movil = $request->operadora;
            $investigador->celular = $request->celular;
            $investigador->email = $request->email ?? $investigador->email;
            $investigador->usuario_id = Auth::id();
            $investigador->save();
            $investigadorAux = InvestigadorAuxiliar::where('investigador_id', $id)->first();
            if ($request->pueblo_indigena_id !== null || 
                $request->tipo_dedicacion_id !== null || 
                $request->tiempo_dedicacion_id !== null || 
                $request->organizacion_social_id !== null) {
                $checkAux = true;
            } else {
                $checkAux = false;
            }
            if (!$investigadorAux && checkAux) {
                DB::table('investigador_auxiliar')->insert([
                    'investigador_id' => $investigadorId,
                    'pueblo_indigena_id' => $request->pueblo_indigena_id,
                    'tipo_dedicacion_id' => $request->tipo_dedicacion_id,
                    'tiempo_dedicacion_id' => $request->tiempo_dedicacion_id,
                    'organizacion_social_id' => $request->organizacion_social_id,
                ]);       
            } else if ($investigadorAux) {
                $investigadorAux->update([
                    'pueblo_indigena_id' => $request->pueblo_indigena_id,
                    'tipo_dedicacion_id' => $request->tipo_dedicacion_id,
                    'tiempo_dedicacion_id' => $request->tiempo_dedicacion_id,
                    'organizacion_social_id' => $request->organizacion_social_id
                ]);
            }
            DB::commit();
            return response()->json([
                'message' => 'Datos actualizados correctamente',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json([
                'message' => 'Error al actualizar los datos',
                'error' => $e->getMessage(),
            ], 500);
        }        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function search_cedula(string $ci) {
        $investigador = DB::table('vperfil_inicial')->where('cedula','=',$ci)->get();
        return response()->json($investigador);
    }
    public function search_email(string $email) {
        $investigador = DB::table('vperfil_inicial')->where('email','=',$email)->get();
        return response()->json($investigador);
    }
    public function logged_investigator(Request $request) {
        $sessionId = Auth::id();
        $investigadores = Investigadores::where('usuario_id', $sessionId)->get();
        if ($investigadores->isEmpty()) {
            return response()->json($this->listados_investigadores(), 200);
        }
        return response()->json([$this->listados_investigadores(),$investigadores], 200);
    }

    public function logged_investigator_view(Request $request) {
        $sessionId = Auth::id();
        $investigadores = Investigadores::leftJoin('nacionalidad', 'nacionalidad.id', '=', 'investigadores.nacionalidad_id')
            ->leftJoin('sexo', 'sexo.id', '=', 'investigadores.sexo_id')
            ->leftJoin('estado_civil', 'estado_civil.id', '=', 'investigadores.estado_civil_id')
            ->leftJoin('estados', 'estados.id', '=', 'investigadores.estado_id')
            ->leftJoin('municipios', function ($join) {
                $join->on('municipios.estado_id', '=', 'estados.id')
                    ->on('municipios.id', '=', 'investigadores.municipio_id');
            })
            ->leftJoin('parroquias', function ($join) {
                $join->on('parroquias.id', '=', 'investigadores.parroquia_id')
                    ->on('parroquias.municipio_id', '=', 'municipios.id');
            })
            ->leftJoin('codigos_postales', 'codigos_postales.id', '=', 'investigadores.codigo_postal_id')
            ->leftJoin('investigador_auxiliar', 'investigador_auxiliar.investigador_id', '=', 'investigadores.id')
            ->leftJoin('pueblo_indigena', function ($join) {
                $join->on('pueblo_indigena.id', '=', 'investigador_auxiliar.pueblo_indigena_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('tipo_dedicacion', function ($join) {
                $join->on('tipo_dedicacion.id', '=', 'investigador_auxiliar.tipo_dedicacion_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('tiempo_dedicacion', function ($join) {
                $join->on('tiempo_dedicacion.id', '=', 'investigador_auxiliar.tiempo_dedicacion_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('organizaciones_sociales', function ($join) {
                $join->on('organizaciones_sociales.id', '=', 'investigador_auxiliar.organizacion_social_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->select(
                'investigadores.id',
                'nacionalidad.nacionalidad',
                'investigadores.cedula',
                'investigadores.pasaporte',
                'investigadores.primer_nombre',
                'investigadores.segundo_nombre',
                'investigadores.primer_apellido',
                'investigadores.segundo_apellido',
                'sexo.sexo',
                'investigadores.fecha_nacimiento',
                'estado_civil.estado_civil',
                'estados.estado',
                'municipios.municipio',
                'parroquias.parroquia',
                'codigos_postales.codigo',
                'investigadores.cod_area_local',
                'investigadores.telefono_local',
                'investigadores.cod_operadora_movil',
                'investigadores.celular',
                'investigadores.email',
                'pueblo_indigena.pueblo_indigena',
                'tipo_dedicacion.tipo_dedicacion',
                'tiempo_dedicacion.tiempo_dedicacion',
                'organizaciones_sociales.organizxacion_social',
                'investigadores.status'
            )
            ->where('usuario_id', $sessionId)
            ->get();        
        if ($investigadores->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }
        $investigadores->transform(function ($investigador) {
            switch ($investigador->status) {
                case 1:
                    $investigador->status = 'ACTIVO';
                    break;
                case 2:
                    $investigador->status = 'SUSPENDIDO';
                    break;
                case 3:
                    $investigador->status = 'DADO DE BAJA';
                    break;
            }
            return $investigador;
        });
        return response()->json($investigadores, 200);
    }

    public function investigators_view(Request $request) {
        ini_set('memory_limit', '256M');
        $investigadores = Investigadores::leftJoin('nacionalidad', 'nacionalidad.id', '=', 'investigadores.nacionalidad_id')
            ->leftJoin('sexo', 'sexo.id', '=', 'investigadores.sexo_id')
            ->leftJoin('estado_civil', 'estado_civil.id', '=', 'investigadores.estado_civil_id')
            ->leftJoin('estados', 'estados.id', '=', 'investigadores.estado_id')
            ->leftJoin('municipios', function ($join) {
                $join->on('municipios.estado_id', '=', 'estados.id')
                    ->on('municipios.id', '=', 'investigadores.municipio_id');
            })
            ->leftJoin('parroquias', function ($join) {
                $join->on('parroquias.id', '=', 'investigadores.parroquia_id')
                    ->on('parroquias.municipio_id', '=', 'municipios.id');
            })
            ->leftJoin('codigos_postales', 'codigos_postales.id', '=', 'investigadores.codigo_postal_id')
            ->leftJoin('investigador_auxiliar', 'investigador_auxiliar.investigador_id', '=', 'investigadores.id')
            ->leftJoin('pueblo_indigena', function ($join) {
                $join->on('pueblo_indigena.id', '=', 'investigador_auxiliar.pueblo_indigena_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('tipo_dedicacion', function ($join) {
                $join->on('tipo_dedicacion.id', '=', 'investigador_auxiliar.tipo_dedicacion_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('tiempo_dedicacion', function ($join) {
                $join->on('tiempo_dedicacion.id', '=', 'investigador_auxiliar.tiempo_dedicacion_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->leftJoin('organizaciones_sociales', function ($join) {
                $join->on('organizaciones_sociales.id', '=', 'investigador_auxiliar.organizacion_social_id')
                    ->on('investigador_auxiliar.investigador_id', '=', 'investigadores.id');
            })
            ->select(
                'investigadores.id',
                'nacionalidad.nacionalidad',
                'investigadores.cedula',
                'investigadores.pasaporte',
                'investigadores.primer_nombre',
                'investigadores.segundo_nombre',
                'investigadores.primer_apellido',
                'investigadores.segundo_apellido',
                'sexo.sexo',
                'investigadores.fecha_nacimiento',
                'estado_civil.estado_civil',
                'estados.estado',
                'municipios.municipio',
                'parroquias.parroquia',
                'codigos_postales.codigo',
                'investigadores.cod_area_local',
                'investigadores.telefono_local',
                'investigadores.cod_operadora_movil',
                'investigadores.celular',
                'investigadores.email',
                'pueblo_indigena.pueblo_indigena',
                'tipo_dedicacion.tipo_dedicacion',
                'tiempo_dedicacion.tiempo_dedicacion',
                'organizaciones_sociales.organizxacion_social',
                'investigadores.status'
            )
            ->get();
        if ($investigadores->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }
        $investigadores->transform(function ($investigador) {
            switch ($investigador->status) {
                case 1:
                    $investigador->status = 'ACTIVO';
                    break;
                case 2:
                    $investigador->status = 'SUSPENDIDO';
                    break;
                case 3:
                    $investigador->status = 'DADO DE BAJA';
                    break;
            }
            return $investigador;
        });
        return response()->json($investigadores, 200);
    }
    public function listados_investigadores() {
        $estadoCivil = EstadoCivil::all();
        $nacionalidad = Nacionalidad::all();
        $sexo = Sexo::all();
        $estados = Estados::all();
        $municipios = Municipios::all();
        $parroquias = Parroquias::all();
        $codigosPostales = CodigosPostales::all();
        $pueblosIndigenas = PueblosIndigenas::all();
        $tiempoDedicacion = TiempoDedicacion::all();
        $tipoDedicacion = TipoDedicacion::all();
        $organizacionesSociales = OrganizacionesSociales::all();

        return response()->json([
            'estadoCivil' => $estadoCivil,
            'nacionalidad' => $nacionalidad,
            'sexo' => $sexo,
            'estados' => $estados,
            'municipios' => $municipios,
            'parroquias' => $parroquias,
            'codigosPostales' => $codigosPostales,
            'pueblosIndigenas' => $pueblosIndigenas,
            'tiempoDedicacion' => $tiempoDedicacion,
            'tipoDedicacion' => $tipoDedicacion,
            'organizacionesSociales' => $organizacionesSociales,
        ]);
    }

}
