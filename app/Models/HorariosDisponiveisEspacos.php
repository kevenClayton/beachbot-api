<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DiasSemana;
use App\Models\Escopos\EstabelecimentoEscopo;
class HorariosDisponiveisEspacos extends Model
{
    use HasFactory;

    protected $table = 'horarios_disponiveis_espaco';
    protected $primaryKey = 'codigo_horario_disponiveis_espaco';
    protected $guarded = [];
    protected $cast = [
        'dia_semana_espaco' => DiasSemana::class
    ];
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('codigo_estabelecimento', Auth::user()->codigo_estabelecimento);
    }
    protected static function booted(): void
    {
        static::addGlobalScope(new EstabelecimentoEscopo);
    }

}
