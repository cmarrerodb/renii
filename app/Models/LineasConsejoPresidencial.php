<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LineasConsejoPresidencial extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'lineas_consejo_presidencial';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'linea_consejo_presidencial',
    ];
    protected $dates = ['deleted_at'];
}
