<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\AgendamentoController;
use App\Http\Controllers\Api\EspacoController;
use App\Http\Controllers\Api\EspacoTipoController;
use App\Http\Controllers\Api\ClienteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'treblle'])->group(function () {

    Route::controller(UsuarioController::class)->prefix('usuario')->group(function () {
        Route::get('/listar', 'listar');
        Route::get('/mostrar', 'mostrar');
    });

    Route::controller(AgendamentoController::class)->prefix('agendamento')->group(function () {
        Route::get('/horarios-disponiveis-no-dia', 'retornarHorariosDisponveisPorDia');
        Route::get('/horarios-agendados-no-dia', 'retornarHorariosAgendadosPorDia');
        Route::get('/horarios-disponiveis-periodo', 'retornarHorariosDisponveisPorPeriodo');
        Route::get('/horarios-agendados-periodo', 'retornarHorariosAgendadosPorPeriodo');
        Route::get('/retornar-proximos-dias', 'retornarProximosDias');
        Route::get('/horarios-funcionamento', 'retornarHorarioFuncionamento');
        Route::post('/criar', 'criarReservaHorario');
    });

    Route::controller(EspacoController::class)->prefix('espaco')->group(function () {
        Route::post('/criar', 'criarEspaco');
        Route::post('/excluir', 'excluirEspaco');
        Route::put('/atualizar', 'atualizarEspaco');
        Route::get('/ver', 'verEspaco');
        Route::get('/listar', 'listarEspaco');
    });
    Route::controller(EspacoTipoController::class)->prefix('tipo-espaco')->group(function () {
        Route::post('/criar', 'criarTipoEspaco');
        Route::post('/excluir', 'excluirTipoEspaco');
        Route::put('/atualizar', 'atualizarTipoEspaco');
        Route::get('/ver', 'verTipoEspaco');
        Route::get('/listar', 'listarTipoEspaco');
    });
    Route::controller(ClienteController::class)->prefix('cliente')->group(function () {
        Route::post('/criar', 'criarCliente');
        Route::post('/excluir', 'excluirCliente');
        Route::put('/atualizar', 'atualizarCliente');
        Route::get('/ver', 'verCliente');
        Route::get('/listar', 'listarCliente');
    });

});

Route::post('/login', [LoginController::class, 'login']);

