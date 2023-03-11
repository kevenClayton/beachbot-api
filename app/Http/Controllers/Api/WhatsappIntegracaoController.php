<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Whatsapp\WhatsappServico;
use App\Services\BaseServico;
use Illuminate\Support\Facades\Log;


class WhatsappIntegracaoController extends Controller
{
    public function  enviarMensagem(Request $request){
        try{

            // Log::debug($request);

            Log::debug($request->hub_challenge);
            return response($request->hub_challenge)->status(200);


            $whatsappServico = new WhatsappServico;
            $retorno = $whatsappServico->enviarMensagem('Teste daqui', '5531992544367');
            dd($retorno);

            return response()->json([
                'message'=> 'Mensagem enviada com sucesso!',
                'retornoWhatsapp' =>$retorno
            ],200);

        }catch(Throwable $e){
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
}
