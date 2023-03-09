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
            $table->longText('descricao')->nullable();
            $table->string('foto_tipo_espaco')->nullable();
            $table->string('icone_tipo_espaco')->nullable();

            $table->unsignedBigInteger('codigo_estabelecimento');
            $table->timestamps();

            $table->foreign('codigo_estabelecimento')->references('codigo_estabelecimento')->on('estabelecimentos');
        });

        DB::table('tipo_espaco')->insert(
            array(
                [
                    'nome_tipo_espaco' => 'Futvôlei',
                    'codigo_estabelecimento' => 1,
                ],

                [
                    'nome_tipo_espaco' => 'Beachtênis',
                    'codigo_estabelecimento' => 1,
                ],

                [
                    'nome_tipo_espaco' => 'Vôlei',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_tipo_espaco' => 'Funcional',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_tipo_espaco' => 'Futvôlei 2',
                    'codigo_estabelecimento' => 2,
                ],

                [
                    'nome_tipo_espaco' => 'Beachtênis2',
                    'codigo_estabelecimento' => 2,
                ],

                [
                    'nome_tipo_espaco' => 'Vôlei2',
                    'codigo_estabelecimento' => 2,
                ],
                [
                    'nome_tipo_espaco' => 'Funcional2',
                    'codigo_estabelecimento' => 2,
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
