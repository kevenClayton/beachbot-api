<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('codigo_cliente');
            $table->string('nome_cliente');
            $table->string('email_cliente')->unique();
            $table->string('celular_cliente')->nullable();
            $table->string('telefone_cliente')->nullable();
            $table->string('cpf_cnpj')->nullable()->unique();
            $table->string('doc')->nullable();
            $table->unsignedBigInteger('codigo_estabelecimento');
            $table->timestamps();

            $table->foreign('codigo_estabelecimento')->references('codigo_estabelecimento')->on('estabelecimentos');
        });
        DB::table('clientes')->insert(
            array(
                [
                'nome_cliente' => 'Keven Clayton',
                'email_cliente' => 'keven.developer@gmail.com',
                'codigo_estabelecimento' => 1,
                ],
                [
                'nome_cliente' => 'Cairo Campos',
                'email_cliente' => 'cairocampos98@gmail.com',
                'codigo_estabelecimento' => 1,
                ],
                [
                'nome_cliente' => 'Numar cliente',
                'email_cliente' => 'numar@gmail.com',
                'codigo_estabelecimento' => 2,
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
        Schema::dropIfExists('clientes');
    }
}
