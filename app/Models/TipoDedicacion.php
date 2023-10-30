<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDedicacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_dedicacion';
    protected $primaryKey = 'id';
    protected $fillable = ['tipo_dedicacion'];
    public $timestamps = false;        
}
