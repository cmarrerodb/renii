<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Identificacion;
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

class IdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show($cedula)
    {
        $identificacion = Identificacion::where('cedula', '=', $cedula)->get();
        $identificacion = json_decode($identificacion,true);
        if (count($identificacion)>0) {
            $sexo = $identificacion[0]['sexo'];
            $idSexo = Sexo::when($sexo == 'M', function ($query) {
                return $query->where('sexo', 'MASCULINO');
            })
            ->when($sexo == 'F', function ($query) {
                return $query->where('sexo', 'FEMENINO');
            })
            ->first('id');
            $identificacion[0]['sexo_id'] =$idSexo['id'];           
            $edo_civil = intval(trim($identificacion[0]['estado_civil']));
            $idEstadoCivil = EstadoCivil::when(in_array($edo_civil, [2, 6]), function ($query) {
                return $query->where('id', '=', 1);
            })
            ->when($edo_civil == 2, function ($query) {
                return $query->where('id', '=', 2);
            })
            ->when(in_array($edo_civil, [4, 8]), function ($query) {
                return $query->where('id', '=', 3);
            })
            ->when(in_array($edo_civil, [1, 5]), function ($query) {
                return $query->where('id', '=', 4);
            })
            ->when(in_array($edo_civil, [3, 7]), function ($query) {
                return $query->where('id', '=', 5);
            })
            ->first('id'); 
            $identificacion[0]['estado_civil'] =$idEstadoCivil['id'];

            $identificacion[0]['primer_apellido']=trim($identificacion[0]['primer_apellido']);
            $identificacion[0]['segundo_apellido']=trim($identificacion[0]['segundo_apellido']);
            $identificacion[0]['primer_nombre']=trim($identificacion[0]['primer_nombre']);
            $identificacion[0]['segundo_nombre']=trim($identificacion[0]['segundo_nombre']);

            return response()->json([
                    $identificacion
                ], 200);
        }
        $identificacion = $this->cne($cedula);
        if ($identificacion !== 'Registro no encontrado') {
            return response()->json([
                $identificacion->original
            ], 200);
        }        
        return response()->json([
            'message' => 'Registro no encontrado'
        ], 404);
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
        $nacionalidad = substr($cedula,0,1);
        $cedula = substr($cedula,2,strlen($cedula));
        if (strlen($cedula) > 0) {
            $nacionalidad_id = Nacionalidad::where('letra','=',$nacionalidad)->first()->id;
            $response = [
                'nacionalidad' => $nacionalidad,
                'nacionalidad_id' => $nacionalidad_id,
                'cedula' => $cedula,
                'primer_nombre' => $nombreParts[0],
                'segundo_nombre' => $nombreParts[1],
                'primer_apellido' => $nombreParts[2],
                'segundo_apellido' => $nombreParts[3],
            ];
            return response()->json($response);
        }
        return response()->json([
            'message' => 'Registro no encontrado'
        ], 404);
    }
}
