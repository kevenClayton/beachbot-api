<?php

namespace App\Http\Requests\Plano;

use Illuminate\Foundation\Http\FormRequest;

class CriarPlanoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'nome_plano' => 'required|max:200',
            'beneficios' => 'required',
            'valor_mensal_plano' => 'required',
            'valor_anual_plano' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'nome_plano.required' => 'O campo nome plano é obrigatório.',
            'beneficios.required' => 'O campo benefícios do plano é obrigatório.',
            'valor_mensal_plano.required' => 'O campo valor mensal do plano é obrigatório.',
            'valor_anual_plano.required' => 'O campo valor anual do plano é obrigatório.',

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
