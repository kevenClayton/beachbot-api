<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaTipoEspaco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_espaco', function (Blueprint $table) {
            $table->id('codigo_tipo_espaco');
            $table->string('nome_tipo_espaco');
            $table->string('foto_tipo_espaco')->nullable();
            $table->timestamps();
        });

        DB::table('tipo_espaco')->insert(
            array(
                [
                    'nome_tipo_espaco' => 'Futvôlei',
                ],

                [
                    'nome_tipo_espaco' => 'Beachtênis',
                ],

                [
                    'nome_tipo_espaco' => 'Vôlei',
                ],
                [
                    'nome_tipo_espaco' => 'Funcional',
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
        Schema::dropIfExists('tipo_espaco');
    }
}
