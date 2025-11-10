<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AreaTerrenoPorTipoImovelRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tipo = request('tipo');
        $valor = (float) $value;

        switch($tipo){
            case 'Terreno':
            case 'Casa':
                if($valor <= 0){
                    $fail("Para o tipo ".$tipo." a área do terreno deve ser maior que Zero.");
                }
                break;
            case 'Apartamento':
                if($valor != 0){
                    $fail("Para o tipo ".$tipo." o campo área do terreno deve ser Zero");;
                }
                break;
            default:
                break;
        }
    }
}
