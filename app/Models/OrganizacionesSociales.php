<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizacionesSociales extends Model
{
    use HasFactory;
    protected $table = 'organizaciones_sociales';
    protected $primaryKey = 'id';
    protected $fillable = ['organizxacion_social'];
    public $timestamps = false;       
}
