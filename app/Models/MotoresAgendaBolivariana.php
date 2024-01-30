<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MotoresAgendaBolivariana extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'motores_agenda_bolivariana';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'motor_agenda_bolivariana',
    ];
    protected $dates = ['deleted_at'];
}
