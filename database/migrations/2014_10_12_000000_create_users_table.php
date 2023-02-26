<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('codigo_usuario');
            $table->string('nome_usuario');
            $table->string('email_usuario')->unique();
            $table->string('cpf_cnpj')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('usuarios')->insert(
            array(
                [
                'nome_usuario' => 'Administrador',
                'email_usuario' => 'administrador@beachbot.com.br',
                'password' => '$2y$10$Dfbgohf8WCW1dxV9rppZOOi07kOzZmSsyDL/wbeHYzqGryJfz1Qba',
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
        Schema::dropIfExists('usuarios');
    }
}
