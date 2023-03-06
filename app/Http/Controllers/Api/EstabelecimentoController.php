<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;
use App\Http\Controllers\Controller;
use App\Http\Requests\EstabelecimentoRequest;
use Throwable;
class EstabelecimentoController extends Controller
{
    public function criarEstabelecimento(EstabelecimentoRequest $request){
        try{

            $dados = $request->all();
            $estabelecimento = Estabelecimento::create($dados);

            return response()->json([
                'message'=> 'Estabelecimento criado com sucesso',
                'estabelecimento' =>$estabelecimento
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function excluirEstabelecimento(Request $request){
        try{

            $dados = $request->all();

            $estabelecimento = Estabelecimento::find($dados['codigo_estabelecimento']);
            $estabelecimento->delete();

            return response()->json([
                'message'=> 'Estabelecimento excluído com sucesso',
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function atualizarEstabelecimento(Request $request){
        try{

            $dados = $request->all();

            $estabelecimento = Estabelecimento::find($dados['codigo_estabelecimento']);
            $estabelecimento->update($dados);

            return response()->json([
                'message'=> 'Estabelecimento atualizado com sucesso!',
                'estabelecimento'=> $estabelecimento
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function verEstabelecimento(Request $request){
        try{

            $dados = $request->all();
            $estabelecimento = Estabelecimento::find($dados['codigo_estabelecimento']);

            return response()->json([
                'message'=> 'Dados do estabelecimento código '.$dados['codigo_estabelecimento'].'!',
                'estabelecimento'=> $estabelecimento
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function listarEstabelecimento(){
        try{

            $listaEstabelecimentos = Estabelecimento::all();

            return response()->json([
                'message'=> 'Lista dos estabelecimentos',
                'estabelecimento'=> $listaEstabelecimentos
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
}
