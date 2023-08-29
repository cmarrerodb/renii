<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model
{
    use HasFactory;
    protected $table = 'ingresos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'usuario_id',
        'fecha_ingreso',
        'token',
        'ip',
        'status_ingreso',
        'fecha_salida',
        'status_salida',
    ];
    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }        
}
