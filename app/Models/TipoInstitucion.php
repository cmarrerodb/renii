<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TipoInstitucion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tipo_institucion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'tipo_institucion',
    ];
    protected $dates = ['deleted_at'];
}
