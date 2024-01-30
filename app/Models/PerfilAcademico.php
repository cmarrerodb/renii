<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PerfilAcademico extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'perfil_academico';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'investigador_id',
        'profesion_id',
        'nivel_estudio_id',
        'institucion_educativa_id',
        'titulo_obtenido',
        'anno_culminacion',
        'pais_id',
        'institucion_educativa',
        'area_id',
        'estudio_superior_id',
        'ambito_id',
        'subarea_id',
        'linea_consejo_presidencial_id',
        'motor_agenda_bolivariana_id',
        'ultimo'
    ];
    protected $dates = ['deleted_at'];
    public function ambito()
    {
        return $this->belongsTo(Ambito::class, 'ambito_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function estudioSuperior()
    {
        return $this->belongsTo(EstudioSuperior::class, 'estudio_superior_id');
    }
    public function investigador()
    {
        return $this->belongsTo(Investigador::class, 'investigador_id');
    }
    public function motorAgendaBolivariana()
    {
        return $this->belongsTo(MotorAgendaBolivariana::class, 'motor_agenda_bolivariana_id');
    }
    public function nivelEstudio()
    {
        return $this->belongsTo(NivelEstudio::class, 'nivel_estudio_id');
    }
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
    public function profesion()
    {
        return $this->belongsTo(Profesion::class, 'profesion_id');
    }
    public function subarea()
    {
        return $this->belongsTo(Subarea::class, 'subarea_id');
    }
    public function lineaConsejoPresidencial()
    {
        return $this->belongsTo(LineaConsejoPresidencial::class, 'linea_consejo_presidencial_id');
    }
}
