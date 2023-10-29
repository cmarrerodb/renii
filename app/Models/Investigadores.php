<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investigadores extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'investigadores';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nacionalidad_id',
        'cedula',
        'pasaporte',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'sexo_id',
        'fecha_nacimiento',
        'estado_civil_id',
        'estado_id',
        'municipio_id',
        'parroquia_id',
        'codigo_postal_id',
        'cod_area_local',
        'telefono_local',
        'cod_operadora_movil',
        'celular',
        'email',
        'estatus',
        'status',
        'usuario_id',
    ];

    protected $dates = ['deleted_at'];

    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class, 'nacionalidad_id');
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
        // return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipios::class, 'municipio_id');
        // return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function parroquia()
    {
        return $this->belongsTo(Parroquias::class, 'parroquia_id');
        // return $this->belongsTo(Parroquia::class, 'parroquia_id');
    }

    public function codigoPostal()
    {
        return $this->belongsTo(CodigosPostales::class, 'codigo_postal_id');
        // return $this->belongsTo(CodigoPostal::class, 'codigo_postal_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
