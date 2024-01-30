<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelEstudioTitulo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'nivel_estudio_titulo';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nivel_estudio_id',
        'estudio_superior_id',
    ];
    protected $dates = ['deleted_at'];
    public function nivelEstudio()
    {
        return $this->belongsTo(NivelEstudio::class, 'nivel_estudio_id');
    }
    public function estudioSuperior()
    {
        return $this->belongsTo(EstudiosSuperiores::class, 'estudio_superior_id');
    }
}
