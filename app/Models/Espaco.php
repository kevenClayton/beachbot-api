<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Espaco extends Model
{
    use HasFactory;

    protected $table = 'espaco';
    protected $primaryKey = 'codigo_espaco';
    protected $guarded = [];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

    public function tipoEspaco()
    {
        return $this->belongsToMany('App\Models\TipoEspaco', 'espaco_tipo_espaco', 'codigo_espaco', 'codigo_tipo_espaco');
    }
}
