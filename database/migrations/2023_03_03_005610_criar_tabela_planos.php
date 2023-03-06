<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CriarTabelaPlanos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id('codigo_plano');
            $table->string('nome_plano');
            $table->string('beneficios');
            $table->float('valor_mensal_plano', 8, 2);
            $table->float('valor_anual_plano', 8, 2);
            $table->boolean('eh_admin')->default(false);

            //Usuarios
            $table->integer('quantidade_usuarios_plano')->nullable();
            $table->integer('quantidade_espacos_plano')->nullable();
            $table->integer('quantidade_cliente_plano')->nullable();

            $table->timestamps();
        });

        DB::table('planos')->insert(
            array(
                [
                    'nome_plano' => 'Administrador do sistema',
                    'beneficios' => '',
                    'valor_mensal_plano' => '(31) 99254-4367',
                    'valor_anual_plano' => 'administrador@beachbot.com.br',
                    'eh_admin' => true,
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
        Schema::dropIfExists('planos');
    }
}
