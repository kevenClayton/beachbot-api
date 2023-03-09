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
            $table->id('codigo_horario_reservado_espaco');
            $table->foreignId('codigo_espaco');
            $table->unsignedBigInteger('codigo_cliente_espaco');
            $table->date('data_reservado_espaco');
            $table->string('hora_inicio_reservado_espaco');
            $table->string('hora_fim_reservado_espaco');
            $table->enum('dia_semana_espaco', ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo']);
            $table->integer('dia_semana_codigo');
            $table->unsignedBigInteger('codigo_estabelecimento');
            $table->timestamps();

            $table->foreign('codigo_estabelecimento')->references('codigo_estabelecimento')->on('estabelecimentos');

            // $table->unsignedBigInteger('codigo_espaco');
            // $table->unsignedBigInteger('codigo_tipo_espaco');

            $table->foreign('codigo_cliente_espaco')->references('codigo_cliente')->on('clientes')->onDelete('cascade');
            // $table->foreign('codigo_tipo_espaco')->references('codigo_tipo_espaco')->on('tipo_espaco')->onDelete('cascade');


        });
        DB::table('horarios_reservados_espaco')->insert(
            array(
                [
                    'codigo_cliente_espaco'=>1,
                    'codigo_espaco'=>1,
                    'data_reservado_espaco' => '2023-02-23',
                    'hora_inicio_reservado_espaco' => '19:00',
                    'hora_fim_reservado_espaco' => '20:00',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'codigo_cliente_espaco'=>2,
                    'codigo_espaco'=>2,
                    'data_reservado_espaco' => '2023-02-23',
                    'hora_inicio_reservado_espaco' => '14:00',
                    'hora_fim_reservado_espaco' => '16:00',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'codigo_cliente_espaco'=>1,
                    'codigo_espaco'=>1,
                    'data_reservado_espaco' => '2023-02-24',
                    'hora_inicio_reservado_espaco' => '17:00',
                    'hora_fim_reservado_espaco' => '21:00',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'codigo_cliente_espaco'=>2,
                    'codigo_espaco'=>2,
                    'data_reservado_espaco' => '2023-02-25',
                    'hora_inicio_reservado_espaco' => '18:00',
                    'hora_fim_reservado_espaco' => '19:00',
                    'codigo_estabelecimento' => 1,
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
