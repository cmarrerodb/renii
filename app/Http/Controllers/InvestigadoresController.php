<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

}
