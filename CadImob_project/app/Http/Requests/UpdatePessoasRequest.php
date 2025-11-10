<?php

namespace App\Http\Requests;

use App\Rules\MaiorDeIdade;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule; 

class UpdatePessoasRequest extends FormRequest
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
            'sexo' => ['required', 'string', 'in:Masculino,Feminino,Outro'],
            'telefone' => ['nullable', 'numeric', 'digits_between:10,11'],
            'email' => ['nullable', 'string', 'email:rfc,dns', Rule::unique('pessoas', 'email')->ignore($this->route('id'))],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required'=>'O campo NOME é obrigatorio!',
            'dataNascimento.required'=>"O campo DATA DE NASCIMENTO é obrigatorio!",
            'sexo.required'=>'O campo SEXO é obrigatorio!',
            'nome.required'=>'O campo NOME é obrigatorio!',
            'dataNascimento.required'=>"O campo DATA DE NASCIMENTO é obrigatorio!",
            'sexo.required'=>'O campo SEXO é obrigatorio!',
            'email.unique' => 'O e‑mail informado já existe.',
            'telefone.digits_between'=> 'O campo telefone deve ter de 10 a 11 digitos',
        ];
    }
}
