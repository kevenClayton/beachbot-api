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
                        "text" => "Notícias"
                    ),
                    "body" => array(
                        "text" => "As notícias são retiradas do site *Kabum Digital*\n\nSelecione uma opção"
                    ),
                    "footer" => array(
                        "text" => "https://kabum.digital/"
                    ),
                    "action" => array(
                        "buttons" => array(
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.mostread",
                                    "title" => "Mais lidas"
                                )
                            ),
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.random",
                                    "title" => "Aleatórias"
                                )
                            ),
                            array(
                                "type" => "reply",
                                "reply" => array(
                                    "id" => "news.latest",
                                    "title" => "Última notícia"
                                )
                            )
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


