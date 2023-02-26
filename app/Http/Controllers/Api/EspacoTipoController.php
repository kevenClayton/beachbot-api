<?php

namespace App\Http\Controllers\Api;
use App\Models\TipoEspaco;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
class EspacoTipoController extends Controller
{
    public function criarTipoEspaco(Request $request){
        try{

            $dados = $request->all();
            $tipoEspaco = TipoEspaco::create($dados);

            return response()->json([
                'message'=> 'Tipo de espaço criado com sucesso',
                'tipoEspaco' =>$tipoEspaco
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function excluirTipoEspaco(Request $request){
        try{

            $dados = $request->all();

            $tipoEspaco = TipoEspaco::find($dados['codigo_tipo_espaco']);
            $tipoEspaco->delete();

            return response()->json([
                'message'=> 'Tipo espaço excluído com sucesso',
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function atualizarTipoEspaco(Request $request){
        try{

            $dados = $request->all();

            $tipoEspaco = TipoEspaco::find($dados['codigo_tipo_espaco']);
            $tipoEspaco->update($dados);

            return response()->json([
                'message'=> 'Tipo espaço atualizado com sucesso!',
                'tipoEspaco'=> $tipoEspaco
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function verTipoEspaco(Request $request){
        try{

            $dados = $request->all();
            $tipoEspaco = TipoEspaco::find($dados['codigo_tipo_espaco']);

            return response()->json([
                'message'=> 'Dados do espaço código '.$dados['codigo_tipo_espaco'].'!',
                'espaco'=> $tipoEspaco
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function ListarTipoEspaco(){
        try{

            $listaTipoEspacos = TipoEspaco::all();

            return response()->json([
                'message'=> 'Lista dos tipos de espaços!',
                'listaTipoEspacos'=> $listaTipoEspacos
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }

}
