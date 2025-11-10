<?php

namespace App\Http\Requests;

use App\Rules\CpfRule;
use App\Rules\MaiorDeIdade;
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

    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'telefone' => preg_replace('/\D/', '', $this->telefone),
        ]);
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
            'dataNascimento' => ['required', 'date', new MaiorDeIdade],
            'cpf' => ['required', 'numeric', 'unique:pessoas,cpf', 'digits:11', new CpfRule], // CPF único na tabela
            'sexo' => ['required', 'string', 'in:Masculino,Feminino,Outro'],
            'telefone' => ['nullable', 'numeric', 'digits_between:10,11'],
            'email' => ['nullable', 'string','email:rfc,dns', 'unique:pessoas,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'=>'O campo NOME é obrigatorio!',
            'dataNascimento.required'=>"O campo DATA DE NASCIMENTO é obrigatorio!",
            'cpf.required'=>'O campo CPF é obrigatorio!',
            'cpf.digits'=>'O campo CPF deve possuir 11 digitos',
            'sexo.required'=>'O campo SEXO é obrigatorio!',
            'email.unique' => 'O e‑mail informado já existe.',
            'email.email' => 'O E-mail deve ser um E-mail valido.',
            'cpf.unique' => 'O cpf informado ja esta em uso',
            'telefone.digits_between'=> 'O campo telefone deve ter de 10 a 11 digitos',
        ];
    }
}
