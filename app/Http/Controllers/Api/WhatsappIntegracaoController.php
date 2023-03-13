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

            $value = $request->input('entry.0.changes.0.value');

            if (isset($value['messages'])) {
                $messages = $value['messages'];
                $id = $messages[0]['id'];
                $destino = $messages[0]['from'];
                $mensagem = $messages[0]['text']['body'] ?? null;
                $location = $messages[0]['location'] ?? null;
                $interactive = $messages[0]['interactive'] ?? null;

                // faz o que desejar com as variáveis acima
            }

            $whatsappServico = new WhatsappServico;
            $retorno = $whatsappServico->enviarMensagemInterativa($mensagem, $destino, $id);
            // $retorno = $whatsappServico->enviarMensagem($mensagem, $destino, $id);

            Log::debug($retorno);

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
