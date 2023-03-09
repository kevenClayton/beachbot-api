<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Throwable;
use App\Http\Requests\Plano\CriarPlanoRequest;
use App\Http\Requests\Plano\AtualizarPlanoRequest;
use App\Models\Planos;

class PlanoController extends Controller
{
    public function criarPlano(CriarPlanoRequest $request){
        try{

            $dados = $request->all();
            $plano = Planos::create($dados);

            return response()->json([
                'message'=> 'Plano criado com sucesso',
                'plano' =>$plano
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function excluirPlano(AtualizarPlanoRequest $request){
        try{

            $dados = $request->all();

            $plano = Planos::find($dados['codigo_plano']);
            $plano->delete();

            return response()->json([
                'message'=> 'Plano excluído com sucesso',
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function atualizarPlano(AtualizarPlanoRequest $request){
        try{

            $dados = $request->all();

            $plano = Planos::find($dados['codigo_plano']);
            $plano->update($dados);

            return response()->json([
                'message'=> 'Plano atualizado com sucesso!',
                'plano'=> $plano
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function verPlano(Request $request){
        try{

            $dados = $request->all();
            $plano = Planos::find($dados['codigo_plano']);

            return response()->json([
                'message'=> 'Dados do plano código '.$dados['codigo_plano'].'!',
                'plano'=> $plano
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function listarPlano(){
        try{

            $listaPlanos = Planos::all();

            return response()->json([
                'message'=> 'Lista dos planos',
                'plano'=> $listaPlanos
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
}
