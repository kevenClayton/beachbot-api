<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Planos;

class Estabelecimento extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $table = 'estabelecimentos';
    protected $primaryKey = 'codigo_estabelecimento';
    public function plano()
    {
        return $this->belongsTo(Planos::class, 'codigo_plano_estabelecimento', 'codigo_plano');
    }
}
