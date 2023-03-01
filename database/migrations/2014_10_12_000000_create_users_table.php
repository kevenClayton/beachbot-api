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
                'password' => bcrypt('123456'),
                ],
                [
                'nome_usuario' => 'Cairo campos',
                'email_usuario' => 'admin@demo.com',
                'password' => bcrypt('demo'),
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
