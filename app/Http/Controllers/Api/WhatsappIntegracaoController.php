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
            Log::info('Webhook whatsap, requisição: '.$request);
            // return $request->query('hub_challenge');

            // $whatsappServico = new WhatsappServico;
            // $retorno = $whatsappServico->enviarMensagem('Teste daqui', '5531992544367');
            return 'teste';


        }catch(Throwable $e){
            Log::debug($e);
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }

    // public function  enviarMensagem(Request $request){ //validarWebhook
    //     try{
    //         Log::info('Webhook whatsap, requisição: '.$request);
    //         return $request->query('hub_challenge');

    //         // $whatsappServico = new WhatsappServico;
    //         // $retorno = $whatsappServico->enviarMensagem('Teste daqui', '5531992544367');



    //     }catch(Throwable $e){
    //         Log::debug($e);
    //         return response()->json([
    //             'error'=> true,
    //             'message'=> $e->getMessage(),
    //         ], 400);
    //     }
    // }
}
