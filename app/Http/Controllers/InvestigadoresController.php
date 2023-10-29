<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Investigadores;
use App\Models\Nacionalidad;
use App\Models\Sexo;
use App\Models\EstadoCivil;
use App\Models\Estados;
use App\Models\Municipios;
use App\Models\Parroquias;
use App\Models\CodigosPostales;

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
        //
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
    public function update(Request $request, string $id)
    {
        //
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
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }
        return response()->json($investigadores, 200);
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

}
