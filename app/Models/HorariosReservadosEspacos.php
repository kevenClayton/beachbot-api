<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Relations\HasMany;use App\Models\Escopos\EstabelecimentoEscopo;

class HorariosReservadosEspacos extends Model
{
    use HasFactory;
    protected $table = "horarios_reservados_espaco";
    protected $primaryKey = 'codigo_horario_reservado_espaco';
    protected $guarded = [];

    public function cliente(): HasMany
    {
        return $this->hasMany(Cliente::class,  'codigo_cliente','codigo_cliente_espaco');
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new EstabelecimentoEscopo);
    }
}
