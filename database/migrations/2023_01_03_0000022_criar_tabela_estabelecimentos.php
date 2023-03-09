<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaEstabelecimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estabelecimentos', function (Blueprint $table) {
            $table->id('codigo_estabelecimento');
            $table->string('nome_estabelecimento');
            $table->string('cnpj_cpf_estabelecimento');
            $table->string('celular_estabelecimento')->nullable();
            $table->string('email_estabelecimento')->nullable();
            $table->boolean('situacao_pagamento_estabelecimento')->default(0);
            $table->unsignedBigInteger('codigo_plano_estabelecimento');
            $table->datetime('data_hora_inicio_teste')->nullable();

            $table->foreign('codigo_plano_estabelecimento')->references('codigo_plano')->on('planos');
            $table->timestamps();
        });

        DB::table('estabelecimentos')->insert(
            array(
                [
                    'nome_estabelecimento' => 'Administrador do sistema',
                    'cnpj_cpf_estabelecimento' => '018.625.876-39',
                    'celular_estabelecimento' => '(31) 99254-4367',
                    'email_estabelecimento' => 'administrador@beachbot.com.br',
                    'situacao_pagamento_estabelecimento' => true,
                    'codigo_plano_estabelecimento' => 1,
                ],
                [
                    'nome_estabelecimento' => 'Numar Sports Beach',
                    'cnpj_cpf_estabelecimento' => '019.224.231-39',
                    'celular_estabelecimento' => '(31) 99254-4367',
                    'email_estabelecimento' => 'administrador@numar.com.br',
                    'situacao_pagamento_estabelecimento' => true,
                    'codigo_plano_estabelecimento' => 2,
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
        Schema::dropIfExists('estabelecimentos');
    }
}
