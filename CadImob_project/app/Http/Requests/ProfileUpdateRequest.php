<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
        ]);
    }

    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'profile' => ['required', 'in:T,S,A'],
            'cpf' => ['required', 'numeric', 'digits:11', new CpfRule(),  Rule::unique('users', 'cpf')->ignore($userId)],
        ];
    }
}
