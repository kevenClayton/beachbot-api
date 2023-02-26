<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspaco extends Model
{
    use HasFactory;
    protected $table = 'tipo_espaco';
    protected $primaryKey = 'codigo_tipo_espaco';
    protected $guarded = [];
    public function espaco()
    {
        return $this->belongsToMany('App\Models\Espaco', 'espaco_tipo_espaco', 'codigo_tipo_espaco', 'codigo_espaco');

    }
}
