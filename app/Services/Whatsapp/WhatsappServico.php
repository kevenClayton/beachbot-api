<?php

namespace App\Services\Whatsapp;

use Illuminate\Http\Client\Response;
use App\Services\BaseServico;

class WhatsappServico extends BaseServico
{
    public function enviarMensagem($mensagem, $EnviarParaNumero)
    {
        $data = [
            'messaging_product'=> 'whatsapp',
            'recipient_type'=> 'individual',
            'to'=> $EnviarParaNumero,
            'type'=> 'text',
            'text'=> [
                'body'=> $mensagem
            ]
            ];
        return $this->post('messages', $data);
    }

}


