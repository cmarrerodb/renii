<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Paises extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'paises';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'codigo',
        'nombre',
    ];
    protected $dates = ['deleted_at'];
}
