<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CursoCapacitacion extends Model
{
    use SoftDeletes;

    protected $table = 'curso_capacitacion';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'investigador_id',
        'capacitacion_id',
        'ambito_id',
        'area_id',
        'subarea_id',
        'linea_consejo_presidencial_id',
        'motor_agenda_bolivariana_id',
        'pais_id',
        'institucion',
        'nombre_curso',
        'horas_academicas',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function investigador()
    {
        return $this->belongsTo('App\Models\Investigador', 'investigador_id');
    }

    public function capacitacion()
    {
        return $this->belongsTo('App\Models\Capacitacion', 'capacitacion_id');
    }

    public function ambito()
    {
        return $this->belongsTo('App\Models\Ambito', 'ambito_id');
    }

    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }

    public function subarea()
    {
        return $this->belongsTo('App\Models\Subarea', 'subarea_id');
    }

    public function lineaConsejoPresidencial()
    {
        return $this->belongsTo('App\Models\LineaConsejoPresidencial', 'linea_consejo_presidencial_id');
    }

    public function motorAgendaBolivariana()
    {
        return $this->belongsTo('App\Models\MotorAgendaBolivariana', 'motor_agenda_bolivariana_id');
    }

    public function pais()
    {
        return $this->belongsTo('App\Models\Pais', 'pais_id');
    }
}
