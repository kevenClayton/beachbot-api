<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espaco extends Model
{
    use HasFactory;

    protected $table = 'espaco';
    protected $primaryKey = 'codigo_espaco';
    protected $guarded = [];

    public function tipoEspaco()
    {
        return $this->belongsToMany('App\Models\TipoEspaco', 'espaco_tipo_espaco', 'codigo_espaco', 'codigo_tipo_espaco');
    }
}
