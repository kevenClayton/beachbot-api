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
            $table->string('cpf_cnpj_usuario')->nullable();
            $table->string('celular_usuario')->nullable();
            $table->string('telefone_usuario')->nullable();
            $table->unsignedBigInteger('codigo_estabelecimento_usuario');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('codigo_estabelecimento_usuario')->references('codigo_estabelecimento')->on('estabelecimentos');
        });

        DB::table('usuarios')->insert(
            array(
                [
                'nome_usuario' => 'Administrador',
                'email_usuario' => 'administrador@beachbot.com.br',
                'codigo_estabelecimento_usuario' => '1',
                'password' => bcrypt('123456'),
                ],
                [
                'nome_usuario' => 'Cairo campos',
                'email_usuario' => 'admin@demo.com',
                'codigo_estabelecimento_usuario' => '1',
                'password' => bcrypt('123456'),
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
