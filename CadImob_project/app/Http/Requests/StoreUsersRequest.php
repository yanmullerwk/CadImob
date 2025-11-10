<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Rules\CpfRule;

class StoreUsersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Limpar campos antes da validação
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'profile' => ['required', 'in:T,S,A'],
            'cpf' => ['required', 'numeric', 'digits:11', 'unique:users,cpf', new CpfRule()],
            'activate' => ['required', 'in:S,N'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser uma string.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',

            'profile.required' => 'O perfil é obrigatório.',
            'profile.in' => 'O perfil deve ser T, S ou A.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.numeric' => 'O CPF deve conter apenas números.',
            'cpf.digits' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',

            'activate.required' => 'O status de ativação é obrigatório.',
            'activate.in' => 'O status de ativação deve ser S ou N.',

            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'A confirmação da senha não confere.',
        ];
    }
}
