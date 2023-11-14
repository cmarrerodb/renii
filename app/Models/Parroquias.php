<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquias extends Model
{
    use HasFactory;
    protected $table = 'parroquias';
    protected $primaryKey = 'id';
    protected $fillable = ['parroquia'];
    public $timestamps = false;

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function codigosPostales()
    {
        return $this->hasMany(CodigoPostal::class, 'parroquia_id');
    }    
}
