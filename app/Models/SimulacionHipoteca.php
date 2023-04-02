<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulacionHipoteca extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = 'SimulacionHipoteca';
    protected $primaryKey = 'ID_simulacion';
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = array();
}
