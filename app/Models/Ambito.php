<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ambito extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ambito';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'ambito',
    ];
    protected $dates = ['deleted_at'];
}
