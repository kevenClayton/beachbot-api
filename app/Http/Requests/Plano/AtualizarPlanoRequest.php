<?php

namespace App\Http\Requests\Plano;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarPlanoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'codigo_plano' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'codigo_plano.required' => 'O código do plano é obrigatório.'

        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
