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
            $table->boolean('situacao')->default(true);
            $table->string('tamanho_espaco')->nullable();

            $table->unsignedBigInteger('codigo_estabelecimento');
            $table->timestamps();

            $table->foreign('codigo_estabelecimento')->references('codigo_estabelecimento')->on('estabelecimentos');
        });
        DB::table('espaco')->insert(
            array(
                [
                    'nome_espaco' => 'Quadra 1',
                    'descricao_espaco' => 'Quadra perto do bar',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_espaco' => 'Quadra 2',
                    'descricao_espaco' => 'Quadra perto do vestiário',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_espaco' => 'Quadra 3',
                    'descricao_espaco' => 'Quadra perto da arquibanca',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_espaco' => 'Quadra 4',
                    'descricao_espaco' => 'Quadra perto do portão',
                    'codigo_estabelecimento' => 1,
                ],
                [
                    'nome_espaco' => 'Quadra 1 numar',
                    'descricao_espaco' => 'Quadra perto do bar',
                    'codigo_estabelecimento' => 2,
                ],
                [
                    'nome_espaco' => 'Quadra 2 numar',
                    'descricao_espaco' => 'Quadra perto do vestiário',
                    'codigo_estabelecimento' => 2,
                ],
                [
                    'nome_espaco' => 'Quadra 3 numar',
                    'descricao_espaco' => 'Quadra perto da arquibanca',
                    'codigo_estabelecimento' => 2,
                ],
                [
                    'nome_espaco' => 'Quadra 4 numar',
                    'descricao_espaco' => 'Quadra perto do portão',
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
        Schema::dropIfExists('espaco');
    }
}
