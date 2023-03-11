<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;

class BaseServico
{
    private function makeRequest()
    {
        return Http::withToken(env('TOKEN_WHATSAPP'));
    }

    protected function get($action)
    {
        return $this->makeRequest()->get($this->getUri($action))->json();
    }

    protected function post($action, $data)
    {
        return $this->makeRequest()->post($this->getUri($action), $data)->json();
    }

    protected function put($action, $data = null)
    {
        return $this->makeRequest()->put($this->getUri($action), $data)->json();
    }

    protected function delete($action)
    {
        return $this->makeRequest()->delete($this->getUri($action))->json();
    }

    private function getUri($action)
    {
        return sprintf('%s%s', env('URL_BASE_API_WHATSAPP').env('ID_NUMERO_WHATSAPP').'/', $action);
    }
}
