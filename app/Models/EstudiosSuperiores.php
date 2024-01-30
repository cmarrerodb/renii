<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EstudiosSuperiores extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'estudios_superiores';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'estudio_superior',
        'usuario_creador',
    ];
    protected $dates = ['deleted_at'];
}
