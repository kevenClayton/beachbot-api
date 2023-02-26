<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioFuncionamento extends Model
{
    use HasFactory;

    protected $table = 'horario_funcionamento';
    protected $primaryKey = 'codigo_horario_funcionamento';
    protected $guarded = [];
    protected $cast = [
        'dia_semana_espaco' => DiasSemana::class
    ];

}
