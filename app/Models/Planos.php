<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estabelecimento;
class Planos extends Model
{
    use HasFactory;
    protected $table = 'planos';
    protected $primaryKey = 'codigo_plano';
    protected $guarded = [];

    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class, 'codigo_plano_estabelecimento', 'codigo_plano');
    }
}
