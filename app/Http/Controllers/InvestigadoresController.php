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
    public function listados_investigadores()
    {
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
    public function cne($ci) {
        $url = "http://www.cne.gob.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula=$ci";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $response1 = curl_exec($curl);
        curl_close($curl);
        $response = str_replace('sta[\'descripcion\'] = $s_res[\'descripcion\'];', '', $response1);
        preg_match('/<td align="left"><b><font color="#00387b">Cédula:<\/font><\/b><\/td>\s+<td align="left">(.*?)<\/td>/', $response, $matches);
        $cedula = $matches[1] ?? '';

        preg_match('/<td align="left"><b><font color="#00387b">Nombre:<\/font><\/b><\/td>\s+<td align="left"><b>(.*?)<\/b><\/td>/', $response, $matches);
        $nombre = $matches[1] ?? '';

        preg_match('/<td align="left"><b><font color="#00387b">Estado:<\/font><\/b><\/td>\s+<td align="left">(.*?)<\/td>/', $response, $matches);
        $estado = $matches[1] ?? '';
        
        preg_match('/<td align="left"><b><font color="#00387b">Municipio:<\/font><\/b><\/td>\s*<td align="left">(.*?)<\/td>/', $response, $matches);        
        $municipio = $matches[1] ?? '';

        preg_match('/<td align="left"><b><font color="#00387b">Parroquia:<\/font><\/b><\/td>\s+<td align="left">(.*?)<\/td>/', $response, $matches);
        $parroquia = $matches[1] ?? '';

        preg_match('/<td align="left"><b><font color="#00387b">Centro:<\/font><\/b><\/td>\s+<td align="left"><font color="#0000FF">(.*?)<\/font><\/td>/', $response, $matches);
        $centro = $matches[1] ?? '';

        preg_match('/<td align="left"><b><font color="#00387b">Dirección:<\/font><\/b><\/td>\s+<td align="left"><font color="#0000FF">(.*?)<\/font><\/td>/', $response, $matches);
        $direccion = $matches[1] ?? '';
        $nombreParts = explode(' ', $nombre);

        $response = [
            'nacionalidad' => 'V',
            'cedula' => $ci,
            'primer_nombre' => $nombreParts[0],
            'segundo_nombre' => $nombreParts[1],
            'primer_apellido' => $nombreParts[2],
            'segundo_apellido' => $nombreParts[3],
            'estado' => $estado,
            'municipio' => $municipio,
            'parroquia' => $parroquia,
            'centro' => $centro,
            'direccion' => $direccion,
        ];

        return response()->json($response);
    }
// public function cne($ci)
// {
//     $client = new Client();
//     $url = "http://www.cne.gob.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula=$ci";
//     $crawler = $client->request('GET', $url);
    
//     $data = $crawler->filter('td')->each(function ($node) {
//         return $node->text();
//     });
    
//     // Ahora $data es un array que contiene todos los td del HTML
//     // Puedes buscar la información que necesitas por su índice
//     $response = [
//         'nacionalidad' => 'V',
//         'cedula' => $ci,
//         'primer_nombre' => $data[1],
//         'segundo_nombre' => $data[3],
//         'primer_apellido' => $data[5],
//         'segundo_apellido' => $data[7],
//         'estado' => $data[9],
//         'municipio' => $data[11],
//         'parroquia' => $data[13],
//         'centro' => $data[15],
//         'direccion' => $data[17],
//     ];

//     return response()->json($response);
// }
// public function cne($ci)
// {
//     $client = new Client();
//     $url = "http://www.cne.gob.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula=$ci";
//     $crawler = $client->request('GET', $url);

//     $data = $crawler->filter('td')->each(function ($node) {
//         return $node->text();
//     });

//     $nacionalidad = substr($data[1], 0, 1); // Obtenemos la primera letra
//     $cedula = intval(substr($data[1], 2)); // Obtenemos el número después del guión

//     $nombre = explode(" ", $data[3]); // Separamos el nombre en partes

//     $primer_nombre = $nombre[0];
//     $segundo_nombre = $nombre[1];
//     $primer_apellido = $nombre[2];
//     $segundo_apellido = $nombre[3];

//     $estado = $data[5];
//     $municipio = $data[7];
//     $parroquia = $data[9];
//     $centro = $data[11];
//     $direccion = $data[13];

//     $response = [
//         'nacionalidad' => $nacionalidad,
//         'cedula' => $cedula,
//         'primer_nombre' => $primer_nombre,
//         'segundo_nombre' => $segundo_nombre,
//         'primer_apellido' => $primer_apellido,
//         'segundo_apellido' => $segundo_apellido,
//         'estado' => $estado,
//         'municipio' => $municipio,
//         'parroquia' => $parroquia,
//         'centro' => $centro,
//         'direccion' => $direccion,
//     ];

//     return response()->json($response);
// }
}
