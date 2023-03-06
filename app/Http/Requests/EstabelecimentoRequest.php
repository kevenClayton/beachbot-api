<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstabelecimentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'nome_estabelecimento' => 'required|max:200',
            'email_estabelecimento' => 'required|email|unique:estabelecimentos,email_estabelecimento',
            'cnpj_cpf_estabelecimento' => 'string|unique:estabelecimentos,cnpj_cpf_estabelecimento',
        ];
    }
    public function messages()
    {
        return [
            'nome_estabelecimento.required' => 'O campo nome estabelecimento é obrigatório.',
            'nome_estabelecimento.max' => 'O campo nome estabelecimento deve ter no máximo :max caracteres.',
            'email_estabelecimento.unique' => 'Já possui um estabelecimento com este e-mail cadastrado',
            'cnpj_cpf_estabelecimento.unique' => 'Já possui um estabelecimento com este CPF ou CNPJ cadastrado',

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
