<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    use HasFactory;
    protected $table = 'estado_civil';
    protected $primaryKey = 'id';
    protected $fillable = ['estado_civil'];
    public $timestamps = false;      
}
