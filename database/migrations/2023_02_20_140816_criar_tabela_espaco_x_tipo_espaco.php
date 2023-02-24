<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaEspacoXTipoEspaco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espaco_tipo_espaco', function (Blueprint $table) {
            $table->id('espaco_codigo_espaco');
            $table->foreignId('codigo_espaco');
            $table->foreignId('codigo_tipo_espaco');
            $table->timestamps();
        });

        DB::table('espaco_tipo_espaco')->insert(
            array(
                [
                    'codigo_espaco' => '1',
                    'codigo_tipo_espaco' => '1',
                ],
                [
                    'codigo_espaco' => '1',
                    'codigo_tipo_espaco' => '2',
                ],
                [
                    'codigo_espaco' => '1',
                    'codigo_tipo_espaco' => '3',
                ],
                [
                    'codigo_espaco' => '1',
                    'codigo_tipo_espaco' => '4',
                ],

                [
                    'codigo_espaco' => '2',
                    'codigo_tipo_espaco' => '1',
                ],

                [
                    'codigo_espaco' => '2',
                    'codigo_tipo_espaco' => '2',
                ],

                [
                    'codigo_espaco' => '2',
                    'codigo_tipo_espaco' => '3',
                ],

                [
                    'codigo_espaco' => '2',
                    'codigo_tipo_espaco' => '4',
                ],


                [
                    'codigo_espaco' => '3',
                    'codigo_tipo_espaco' => '1',
                ],

                [
                    'codigo_espaco' => '3',
                    'codigo_tipo_espaco' => '2',
                ],

                [
                    'codigo_espaco' => '3',
                    'codigo_tipo_espaco' => '3',
                ],

                [
                    'codigo_espaco' => '3',
                    'codigo_tipo_espaco' => '4',
                ],

                [
                    'codigo_espaco' => '4',
                    'codigo_tipo_espaco' => '1',
                ],

                [
                    'codigo_espaco' => '4',
                    'codigo_tipo_espaco' => '2',
                ],

                [
                    'codigo_espaco' => '4',
                    'codigo_tipo_espaco' => '3',
                ],

                [
                    'codigo_espaco' => '4',
                    'codigo_tipo_espaco' => '4',
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
        Schema::dropIfExists('espaco_tipo_espaco');
    }
}
