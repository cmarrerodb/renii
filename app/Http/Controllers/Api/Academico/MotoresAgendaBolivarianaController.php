<?php
namespace App\Http\Controllers\API\Academico;
use App\Http\Controllers\Controller;
use App\Models\MotoresAgendaBolivariana;
use Illuminate\Http\Request;
class MotoresAgendaBolivarianaController extends Controller
{
    public function index()
    {
        $motoresAgendaBolivariana = MotoresAgendaBolivariana::all();
        return response()->json($motoresAgendaBolivariana);
    }
    public function show(MotoresAgendaBolivariana $motoresAgendaBolivariana)
    {
        return response()->json($motoresAgendaBolivariana);
    }
    public function store(Request $request)
    {
        $request->validate([
            'motor_agenda_bolivariana' => 'required|string|max:150',
        ], [
            'motor_agenda_bolivariana.required' => 'El campo motor_agenda_bolivariana es requerido.',
            'motor_agenda_bolivariana.string' => 'El campo motor_agenda_bolivariana debe ser una cadena de caracteres.',
            'motor_agenda_bolivariana.max' => 'El campo motor_agenda_bolivariana no debe exceder los 150 caracteres.',
        ]);
        $motoresAgendaBolivariana = MotoresAgendaBolivariana::create($request->all());
        return response()->json([
            'message' => 'Registro creado exitosamente',
            'data' => $motoresAgendaBolivariana,
        ], 201);
    }
    public function update(Request $request, MotoresAgendaBolivariana $motoresAgendaBolivariana)
    {
        $request->validate([
            'motor_agenda_bolivariana' => 'required|string|max:150',
        ], [
            'motor_agenda_bolivariana.required' => 'El campo motor_agenda_bolivariana es requerido.',
            'motor_agenda_bolivariana.string' => 'El campo motor_agenda_bolivariana debe ser una cadena de caracteres.',
            'motor_agenda_bolivariana.max' => 'El campo motor_agenda_bolivariana no debe exceder los 150 caracteres.',
        ]);
        $motoresAgendaBolivariana->update($request->all());
        return response()->json([
            'message' => 'Registro actualizado exitosamente',
            'data' => $motoresAgendaBolivariana,
        ], 201);
    }
    public function destroy(MotoresAgendaBolivariana $motoresAgendaBolivariana)
    {
        $motoresAgendaBolivariana->delete();
        return response()->json([
            'message' => 'Registro eliminado exitosamente'
        ], 204);
    }
}