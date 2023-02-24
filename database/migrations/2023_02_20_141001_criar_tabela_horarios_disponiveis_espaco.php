<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaHorariosDisponiveisEspaco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_disponiveis_espaco', function (Blueprint $table) {
            $table->id('codigo_horario_espaco');
            $table->enum('dia_semana_espaco', ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo']);
            $table->integer('dia_semana_codigo');
            $table->foreignId('codigo_espaco');
            $table->string('horario_espaco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios_disponiveis_espaco');
    }
}
