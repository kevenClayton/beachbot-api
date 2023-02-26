<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DiasSemana;

class HorariosDisponiveisEspacos extends Model
{
    use HasFactory;

    protected $table = 'horarios_disponiveis_espaco';
    protected $primaryKey = 'codigo_horario_disponiveis_espaco';
    protected $guarded = [];
    protected $cast = [
        'dia_semana_espaco' => DiasSemana::class
    ];


}
