<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigosPostales extends Model
{
    use HasFactory;
    protected $table = 'codigos_postales';
    protected $primaryKey = 'id';
    protected $fillable = ['codigo'];
    public $timestamps = false;

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'parroquia_id');
    }    
}
