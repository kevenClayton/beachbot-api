<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EspacoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome_espaco' => 'required|max:200',
            // 'codigo_tipo_espaco' => 'required|array',
            // 'codigo_tipo_espaco.*' => 'exists:codigo_tipo_espaco,id',
        ];
    }
    public function messages()
    {
        return [
            'nome_espaco.required' => 'O campo nome é obrigatório.',
            'nome_espaco.max' => 'O campo mensagem deve ter no máximo :max caracteres.',
            // 'codigo_tipo_espaco.required' => 'O tipo de espaço tem que ser enviado um array com os tipos',

        ];
    }
}
