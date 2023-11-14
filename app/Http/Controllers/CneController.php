<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Cne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
class CneController extends Controller
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
        return response()->json([
            'message' => 'El registro del usuario ha sido exitoso'
        ], 201);
        return Cne::where('cedula', '=', $cedula)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cne $cne)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cne $cne)
    {
        //
    }
}
