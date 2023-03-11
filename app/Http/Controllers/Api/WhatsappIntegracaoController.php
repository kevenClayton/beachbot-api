<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Whatsapp\WhatsappServico;
use App\Services\BaseServico;
use Illuminate\Support\Facades\Log;
use Throwable;

class WhatsappIntegracaoController extends Controller
{
    public function  enviarMensagem(Request $request){
        try{

            // Log::debug($request);

            Log::debug( $request->query('hub_challenge'));
            return response()->json([
                'data'=> $request->query('hub_challenge')
            ],200);


            // $whatsappServico = new WhatsappServico;
            // $retorno = $whatsappServico->enviarMensagem('Teste daqui', '5531992544367');



        }catch(Throwable $e){
            Log::debug($e);
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
}
