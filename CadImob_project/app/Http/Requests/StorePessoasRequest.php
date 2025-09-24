<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePessoasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //por enquanto true
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // [return [
        //     'nome' => ['required', 'string', 'max:255'],
        //     'data_nascimento' => ['required', 'date'],
        //     'cpf' => ['required', 'string', 'unique:pessoas,cpf'], // CPF único na tabela
        //     'sexo' => ['required', 'string', 'in:M,F,O'],
        //     'telefone' => ['nullable', 'string', 'max:20'],
        //     'email' => ['nullable', 'string', 'email'],
        // ];]
    }
}
