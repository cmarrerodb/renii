<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesos extends Model
{
    use HasFactory;
    protected $table = 'accesos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable= [
        'login_usuario',
        'ingreso',
        'ip',
        'estatus',
        'salida',
        'expirado',
    ];

}
