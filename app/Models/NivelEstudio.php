<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class NivelEstudio extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'nivel_estudio';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nivel_estudio',
        'orden',
    ];
    protected $dates = ['deleted_at'];
}

