<?php

namespace App\Http\Requests;

use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePessoasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'dataNascimento' => ['required', 'date'],
            'cpf' => ['required', 'numeric', 'unique:pessoas,cpf', new CpfRule], // CPF único na tabela
            'sexo' => ['required', 'string', 'in:Masculino,Feminino,Outro'],
            'telefone' => ['nullable', 'numeric'],
            'email' => ['nullable', 'string','email:rfc,dns'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'=>'O campo NOME é obrigatorio!',
            'dataNascimento.required'=>"O campo DATA DE NASCIMENTO é obrigatorio!",
            'cpf.required'=>'O campo CPF é obrigatorio!',
            'sexo.required'=>'O campo SEXO é obrigatorio!',
        ];
    }
}
