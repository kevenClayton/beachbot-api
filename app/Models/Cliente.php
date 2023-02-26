<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'codigo_cliente';
    protected $table = 'clientes';
}
