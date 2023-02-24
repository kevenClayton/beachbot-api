<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\AgendamentoController;


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
        Route::get('/horarios-disponiveis-1-dia', 'carregarHorariosDisponveisPorDia');
        Route::get('/retornar-proximos-7-dias', 'retornarProximos7Dias');
        Route::get('/horario-funcionamento', 'horariosFuncionamentoEstabelecimento');
        Route::get('/todos-horarios-disponiveis', 'todosHorariosDisponiveis');
        Route::get('/todos-horarios-marcados', 'retornarTodosHorariosAgendados');
        Route::get('/horarios-disponiveis-um-item/{tipo}', 'horariosDisponiveisUmItem'); // Pegar horário disponível somente de um item, exemplo quadra futvolei
        Route::post('/marcar-horario-um-item', 'horariosDisponiveisUmItem');
    });

});

Route::post('/login', [LoginController::class, 'login']);

