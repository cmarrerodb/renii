<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Profesion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'profesiones';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'profesion',
    ];
    protected $dates = ['deleted_at'];
}

