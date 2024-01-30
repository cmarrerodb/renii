<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Capacitacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'capacitacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'capacitacion',
    ];
    protected $dates = ['deleted_at'];
}
