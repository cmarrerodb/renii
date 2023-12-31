<?php

namespace App\Http\Controllers\Api\Investigadores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PueblosIndigenasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pueblos_indigenas = DB::table('pueblo_indigena')->orderBy('pueblo_indigena')->get();
        return response()->json($pueblos_indigenas);
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
    public function search_pueblo(string $pueblo) {
        $pueblo_indigena = DB::table('pueblo_indigena')->where('pueblo_indigena','=',$pueblo)->get();
        return response()->json($pueblo_indigena);
    }    
}
