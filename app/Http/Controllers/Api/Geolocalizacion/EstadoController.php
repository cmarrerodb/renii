<?php

namespace App\Http\Controllers\Api\Geolocalizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Estados;
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
        // $estado = DB::table('estados')->where('id','=',$estado_id)->get();
        return response()->json($estado);
    }    
}
