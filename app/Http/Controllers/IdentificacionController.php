<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Identificacion;

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
        if (count($identificacion)>0) {
            return response()->json([
                $identificacion
            ], 200);
        }
        return response()->json([
            'message' => 'Registro no encontrado'
        ], 404);
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
