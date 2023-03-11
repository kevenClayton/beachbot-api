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
            Log::info('Webhook whatsap, requisição: '.$request->entry);
            // return $request->query('hub_challenge');

            $dadosWhatsapp =   $request->input();
            $dadosWhatsapp['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
            Log::debug('Mensagem whatsap, requisição: '.$dadosWhatsapp);

            $whatsappServico = new WhatsappServico;
            $retorno = $whatsappServico->enviarMensagem('Teste daqui', '5531992544367');
            return 'teste';


        }catch(Throwable $e){
            Log::debug($e);
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }

    public function  validarWebhook(Request $request){ //validarWebhook
        try{
            Log::info('Webhook whatsap, requisição: '.$request);
            return $request->query('hub_challenge');
        }catch(Throwable $e){
            Log::debug($e);
            return response()->json([
                'error'=> true,
                'message'=> $e->getMessage(),
            ], 400);
        }
    }
}
