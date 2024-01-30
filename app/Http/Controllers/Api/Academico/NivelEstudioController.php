<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NivelEstudio;

class NivelEstudioController extends Controller
{
    /**
     * Mostrar todos los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nivelEstudios = NivelEstudio::all();
        return response()->json($nivelEstudios);
    }

    /**
     * Mostrar un registro específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nivelEstudio = NivelEstudio::findOrFail($id);
        return response()->json($nivelEstudio);
    }

    /**
     * Almacenar un nuevo registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nivelEstudio = NivelEstudio::create($request->all());
        return response()->json(['message' => 'Registro creado correctamente'], 201);
    }

    /**
     * Actualizar un registro existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nivelEstudio = NivelEstudio::findOrFail($id);
        $nivelEstudio->update($request->all());
        return response()->json(['message' => 'Registro actualizado correctamente'], 201);

    }

    /**
     * Eliminar un registro con SoftDeletes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nivelEstudio = NivelEstudio::findOrFail($id);
        $nivelEstudio->delete();
        return response()->json(['message' => 'Registro eliminado correctamente'], 204);
    }
}
