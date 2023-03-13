<?php

namespace App\Services\Whatsapp;

use Illuminate\Http\Client\Response;
use App\Services\BaseServico;

class WhatsappServico extends BaseServico
{
    public function enviarMensagem($mensagem, $EnviarParaNumero, $wmaid = "")
    {
        if($wmaid != ""){
            $data = [
                'messaging_product'=> 'whatsapp',
                'recipient_type'=> 'individual',
                'context'=> [
                    'message_id'=> $wmaid
                ],
                'to'=> $EnviarParaNumero,
                'type'=> 'text',
                'text'=> [
                    'body'=> $mensagem
                ]
            ];
        }else{
            $data = [
                'messaging_product'=> 'whatsapp',
                'recipient_type'=> 'individual',
                'to'=> $EnviarParaNumero,
                'type'=> 'text',
                'text'=> [
                    'body'=> $mensagem
                ]
            ];
        }

        return $this->post('messages', $data);
    }
    public function enviarMensagemInterativa($mensagem, $EnviarParaNumero, $wmaid = "")
    {
        if($wmaid != ""){
            $data = [
                'messaging_product'=> 'whatsapp',
                'to'=> $EnviarParaNumero,
                'type'=> 'interactive',
                'interactive'=>[
                    "type" => "button",
                    "header" => array(
                        "type" => "text",
                        "text" => "Bem vindo a Numar, o que deseja ?"
                    ),
                    "body" => array(
                        "text" => "Por aqui, você pode saber valores, horários de quadras disponíveis e até reservar seu horário"
                    ),
                    "footer" => array(
                        "text" => "Selecione uma opção:"
                    ),
                    "action" => array(
                        "buttons" => array(
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.mostread",
                                    "title" => "Agendar horário"
                                )
                            ),
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.random",
                                    "title" => "Informações de valores"
                                )
                            ),
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.latest",
                                    "title" => "Informações de aulas"
                                )
                            ),
                        )
                    )
                ],
                'context'=> [
                    'message_id'=> $wmaid
                ],

            ];
        }else{
            $data = [
                'messaging_product'=> 'whatsapp',
                'recipient_type'=> 'individual',
                'to'=> $EnviarParaNumero,
                'type'=> 'text',
                'text'=> [
                    'body'=> $mensagem
                ]
            ];
        }

        return $this->post('messages', $data);
    }

}


