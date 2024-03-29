<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Area extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'areas';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'area',
    ];
    protected $dates = ['deleted_at'];
}
