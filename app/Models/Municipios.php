<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    protected $primaryKey = 'id';
    protected $fillable = ['municipio'];
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function parroquias()
    {
        return $this->hasMany(Parroquia::class, 'municipio_id');
    }    
}
