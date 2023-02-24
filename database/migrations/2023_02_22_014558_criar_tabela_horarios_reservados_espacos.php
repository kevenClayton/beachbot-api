<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaHorariosReservadosEspacos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_reservados_espaco', function (Blueprint $table) {
            $table->id('codigo_horario_espaco');
            $table->foreignId('codigo_espaco');
            $table->string('id_cliente_espaco');
            $table->dateTime('data_hora_inicio_reservado_espaco');
            $table->dateTime('data_hora_fim_reservado_espaco');
            $table->enum('dia_semana_espaco', ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo']);
            $table->integer('dia_semana_codigo');
            $table->timestamps();
        });
        DB::table('horarios_reservados_espaco')->insert(
            array(
                [
                    'id_cliente_espaco'=>1,
                    'codigo_espaco'=>1,
                    'data_hora_inicio_reservado_espaco' => '2023-02-23 19:00:00',
                    'data_hora_fim_reservado_espaco' => '2023-02-23 20:00:00',
                ],
                [
                    'id_cliente_espaco'=>2,
                    'codigo_espaco'=>2,
                    'data_hora_inicio_reservado_espaco' => '2023-02-23 14:00:00',
                    'data_hora_fim_reservado_espaco' => '2023-02-23 16:00:00',
                ],
            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios_reservador_espaco');
    }
}
