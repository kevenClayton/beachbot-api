<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaEspaco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espaco', function (Blueprint $table) {
            $table->id('codigo_espaco');
            $table->string('nome_espaco');
            $table->string('descricao_espaco')->nullable();
            $table->string('foto_espaco')->nullable();
            $table->string('tamanho')->nullable();
            $table->timestamps();
        });
        DB::table('espaco')->insert(
            array(
                [
                    'nome_espaco' => 'Quadra 1',
                    'descricao_espaco' => 'Quadra perto do bar',
                ],
                [
                    'nome_espaco' => 'Quadra 2',
                    'descricao_espaco' => 'Quadra perto do vestiário',
                ],
                [
                    'nome_espaco' => 'Quadra 3',
                    'descricao_espaco' => 'Quadra perto da arquibanca',
                ],
                [
                    'nome_espaco' => 'Quadra 4',
                    'descricao_espaco' => 'Quadra perto do portão',
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
        Schema::dropIfExists('espaco');
    }
}
