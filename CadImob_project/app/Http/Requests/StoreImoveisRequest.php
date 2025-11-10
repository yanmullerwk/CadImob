<?php

namespace App\Http\Requests;

use App\Rules\AreaEdificacaoPorTipoImovelRule;
use App\Rules\AreaTerrenoPorTipoImovelRule;
use App\Rules\TipoImovelRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImoveisRequest extends FormRequest
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
            'tipo' => ['required', 'string', 'in:Terreno,Casa,Apartamento'],
            'areaTerreno' => ['required', 'numeric', 'min:0', new AreaTerrenoPorTipoImovelRule],
            'areaEdificacao' => ['required', 'numeric', 'min:0', new AreaEdificacaoPorTipoImovelRule],
            'logradouro' => ['required', 'string', 'max:255'],
            'numero' => ['required', 'string', 'max:20'],
            'bairro' => ['required', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'contribuinte_id' => ['required', 'exists:pessoas,id'], // FK
            'situação' => ['nullable', 'string', 'in:ATIVO,INATIVO'],
            'documents'=> ['nullable', 'array', 'max:5'],
            'documents.*'=>['file', 'mimes:jpg,jpeg,png,pdf', 'max:3072']
        ];
    }

    public function messages()
    {
        return 
        [
            'tipo.required' => 'O tipo do Imóvel é Obrigatório.',
            'logradouro.required' => 'O campo Logradouro é Obrigatório',
            'numero.required' => 'O campo numero é Obrigatorio',
            'bairro.required' => 'O campo bairro é Obrigatório',
            'contribuinte_id' => 'O campo contribuinte é Obrigatório',
            'areaEdificacao.required' => 'O campo Área edificação não pode ficar vazio',
            'areaTerreno.required' => 'O campo Área Terreno não pode ficar vazio',
        ];
    }
}
