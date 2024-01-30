<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Instituciones extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'instituciones';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'tipo_institucion_id',
        'nombre_institucion',
    ];
    protected $dates = ['deleted_at'];
    public function tipoInstitucion()
    {
        return $this->belongsTo(TipoInstitucion::class, 'tipo_institucion_id');
    }
}
