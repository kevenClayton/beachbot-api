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
            $table->timestamps();
        });
        DB::table('clientes')->insert(
            array(
                [
                'nome_cliente' => 'Keven Clayton',
                'email_cliente' => 'keven.developer@gmail.com',
                ],
                [
                'nome_cliente' => 'Cairo Campos',
                'email_cliente' => 'cairocampos98@gmail.com',
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
