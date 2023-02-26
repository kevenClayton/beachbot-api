<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'nome_cliente' => 'required|max:200',
            'email_cliente' => 'required|email|unique:clientes,email_cliente',
            'cpf_cnpj' => 'string|unique:clientes,cpf_cnpj',
        ];
    }
    public function messages()
    {
        return [
            'nome_cliente.required' => 'O campo nome cliente é obrigatório.',
            'nome_cliente.max' => 'O campo nome cliente deve ter no máximo :max caracteres.',
            'email_cliente.unique' => 'Já possui um cliente com este e-mail cadastrado',
            'cpf_cnpj.unique' => 'Já possui um cliente com este CPF ou CNPJ cadastrado',

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
