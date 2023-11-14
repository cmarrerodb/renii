<?php

namespace App\Http\Controllers\Api\Geolocalizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Estados;
use App\Models\Municipios;
use App\Models\Parroquias;
use Illuminate\Http\Response;
class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // $estados = DB::table('estados')->orderBy('id')->get();
        $estados = Estados::orderBy('id')->get();
        return response()->json($estados);
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
    public function search_estado(string $estado_id) {       
        $estado = Estados::where('id','=',$estado_id)->get();
        return response()->json($estado);
    }
    public function estado_municipios(Request $request, $estado_id) {
        $municipios = Municipios::where('estado_id', $estado_id)
            ->orderBy('municipio', 'asc')
            ->get(['id', 'cod_municipio', 'municipio']);

        if ($municipios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }
        return response()->json($municipios, 200);
    }          
    public function municipio_parroquias(Request $request, $municipio_id) {
        $parroquias = Parroquias::where('municipio_id', $municipio_id)
            ->orderBy('parroquia', 'asc')
            ->get(['id', 'cod_parroquia', 'parroquia']);

        if ($parroquias->isEmpty()) {
            return response()->json(['message' => 'No se encontraron registros'], 404);
        }
        return response()->json($parroquias, 200);
    }          
}
