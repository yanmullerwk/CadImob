<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePessoasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       // Obtém o ID da pessoa que está sendo atualizada
        $pessoaId = $this->route('pessoa')->id;

        // return [
        //     'nome' => ['required', 'string', 'max:255'],
        //     'data_nascimento' => ['required', 'date'],
        //     // Ignora o CPF único para o registro atual
        //     'cpf' => ['required', 'string', 'unique:pessoas,cpf,' . $pessoaId],
        //     'sexo' => ['required', 'string', 'in:M,F,O'],
        //     'telefone' => ['nullable', 'string', 'max:20'],
        //     'email' => ['nullable', 'string', 'email'],
        // ];
    }
}
