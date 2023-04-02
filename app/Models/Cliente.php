<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = 'Cliente';
    protected $primaryKey = 'ID_cliente';
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = array();

    public function simulaciones_hipotecas()
    {
        return $this->hasMany('App\Models\SimulacionHipoteca', 'FK_cliente');
    }
}
