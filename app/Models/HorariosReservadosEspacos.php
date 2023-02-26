<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosReservadosEspacos extends Model
{
    use HasFactory;
    protected $table = "horarios_reservados_espaco";
    protected $primaryKey = 'codigo_horario_reservado_espaco';
    protected $guarded = [];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
