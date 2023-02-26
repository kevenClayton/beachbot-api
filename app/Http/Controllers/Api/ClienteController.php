<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;

use Throwable;

class ClienteController extends Controller
{
    public function criarCliente(ClienteRequest $request){
        try{

            $dados = $request->all();
            $cliente = Cliente::create($dados);

            return response()->json([
                'message'=> 'cliente criado com sucesso',
                'cliente' =>$cliente
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function excluirCliente(Request $request){
        try{

            $dados = $request->all();

            $cliente = Cliente::find($dados['codigo_cliente']);
            $cliente->delete();

            return response()->json([
                'message'=> 'Cliente excluído com sucesso',
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function atualizarCliente(Request $request){
        try{

            $dados = $request->all();

            $cliente = Cliente::find($dados['codigo_cliente']);
            $cliente->update($dados);

            return response()->json([
                'message'=> 'Cliente atualizado com sucesso!',
                'cliente'=> $cliente
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function verCliente(Request $request){
        try{

            $dados = $request->all();
            $cliente = Cliente::find($dados['codigo_cliente']);

            return response()->json([
                'message'=> 'Dados do cliente código '.$dados['codigo_cliente'].'!',
                'cliente'=> $cliente
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
    public function listarCliente(){
        try{

            $listaClientes = Cliente::all();

            return response()->json([
                'message'=> 'Lista dos clientes',
                'cliente'=> $listaClientes
            ], 200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }

}
