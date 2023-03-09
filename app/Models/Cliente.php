<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Escopos\EstabelecimentoEscopo;

use HorariosReservadosEspacos;

class Cliente extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'codigo_cliente';
    protected $table = 'clientes';

    public function horariosReservados(): BelongsTo
    {
        return $this->belongsTo(HorariosReservadosEspacos::class, '');
    }
    protected static function booted(): void
    {
        static::addGlobalScope(new EstabelecimentoEscopo);
    }
}
