<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaHorarioFuncionamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('horario_funcionamento', function (Blueprint $table) {
            $table->id('codigo_horario_funcionamento');
            $table->enum('dia_semana_horario_funcionamento', ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo']);
            $table->integer('dia_semana_codigo');
            $table->string('horario_funcionamento_inicio');
            $table->string('horario_funcionamento_fim');
            $table->timestamps();
        });

        DB::table('horario_funcionamento')->insert(
            array(
                [
                    'dia_semana_horario_funcionamento' => 'segunda',
                    'horario_funcionamento_inicio' => '14:00',
                    'horario_funcionamento_fim' => '23:00',
                    'dia_semana_codigo'=> 1,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'terca',
                    'horario_funcionamento_inicio' => '14:00',
                    'horario_funcionamento_fim' => '23:00',
                    'dia_semana_codigo'=> 2,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'quarta',
                    'horario_funcionamento_inicio' => '14:00',
                    'horario_funcionamento_fim' => '23:00',
                    'dia_semana_codigo'=> 3,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'quinta',
                    'horario_funcionamento_inicio' => '14:00',
                    'horario_funcionamento_fim' => '23:00',
                    'dia_semana_codigo'=> 4,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'sexta',
                    'horario_funcionamento_inicio' => '13:00',
                    'horario_funcionamento_fim' => '23:00',
                    'dia_semana_codigo'=> 5,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'sabado',
                    'horario_funcionamento_inicio' => '08:00',
                    'horario_funcionamento_fim' => '18:00',
                    'dia_semana_codigo'=> 6,
                ],
                [
                    'dia_semana_horario_funcionamento' => 'domingo',
                    'horario_funcionamento_inicio' => '08:00',
                    'horario_funcionamento_fim' => '13:00',
                    'dia_semana_codigo'=> 0,
                ],

            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horario_funcionamento');
    }
}
