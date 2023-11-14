<?php

namespace App\Http\Controllers\Api\Investigadores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TipoDedicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_dedicacion = DB::table('tipo_dedicacion')->orderBy('id')->get();
        return response()->json($tipo_dedicacion);
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
}
