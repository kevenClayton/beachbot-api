<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Espaco;
use App\Http\Requests\EspacoRequest;
use App\Models\TipoEspaco;

use Throwable;
class EspacoController extends Controller
{
    public function criarEspaco(EspacoRequest $request){
        try{

            $dados = $request->except('codigo_tipo_espaco');
            $espaco = Espaco::create($dados);

            $tipoEspaco =  $request->input('codigo_tipo_espaco');;

            $espaco->tipoEspaco()->attach($tipoEspaco);

            return response()->json([
                'message'=> 'Espaço criado com sucesso',
                'espaco' =>$espaco
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function excluirEspaco(Request $request){
        try{

            $dados = $request->all();

            $espaco = Espaco::find($dados['codigo_espaco']);
            $espaco->delete();

            return response()->json([
                'message'=> 'Espaço excluído com sucesso',
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function atualizarEspaco(Request $request){
        try{

            $dados = $request->except('codigo_tipo_espaco');

            $espaco = Espaco::find($dados['codigo_espaco']);
            $espaco->update($dados);

            $tipoEspaco =  $request->input('codigo_tipo_espaco');;
            $espaco->tipoEspaco()->detach();
            $espaco->tipoEspaco()->attach($tipoEspaco);

            return response()->json([
                'message'=> 'Espaço atualizado com sucesso!',
                'espaco'=> $espaco
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function verEspaco(Request $request){
        try{

            $dados = $request->all();
            $espaco = Espaco::with('tipoEspaco')->find($dados['codigo_espaco']);

            return response()->json([
                'message'=> 'Dados do espaço código '.$dados['codigo_espaco'].'!',
                'espaco'=> $espaco
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function listarEspaco(){
        try{

            $listaEspacos = Espaco::with('tipoEspaco')->get();

            return response()->json([
                'message'=> 'Lista dos espaços',
                'espaco'=> $listaEspacos
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }



}
