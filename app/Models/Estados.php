<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estados extends Model
{
    // use HasFactory;
    // protected $table = 'estados';
    // protected $primaryKey = 'id';
    // protected $fillable = ['estado','poblacion'];
    // public $timestamps = false;
    use HasFactory, SoftDeletes;

    protected $table = 'estados';
    protected $primaryKey = 'id';
    protected $fillable = ['cod_estado', 'estado', 'poblacion'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function municipios() {
        return $this->hasMany(Municipio::class, 'estado_id');
    }    
}
