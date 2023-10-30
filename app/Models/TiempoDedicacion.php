<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiempoDedicacion extends Model
{
    use HasFactory;
    protected $table = 'tiempo_dedicacion';
    protected $primaryKey = 'id';
    protected $fillable = ['tiempo_dedicacion'];
    public $timestamps = false;       
}
