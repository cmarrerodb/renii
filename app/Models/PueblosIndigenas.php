<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PueblosIndigenas extends Model
{
    use HasFactory;
    protected $table = 'pueblo_indigena';
    protected $primaryKey = 'id';
    protected $fillable = ['pueblo_indigena'];
    public $timestamps = false;       
}
