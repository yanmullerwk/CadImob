<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function PHPUnit\Framework\isEmpty;

class AreaEdificacaoPorTipoImovelRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tipo = request('tipo');
        
        error_log($tipo);

        $valor = (float) $value;
        switch($tipo){
            case 'Terreno':
                if($valor != 0){
                    $fail("Para o tipo ".$tipo." a area de edificação deve ser Zero.");
                }
                break;
            case 'Casa':
                if($valor <= 0){
                    $fail("Para o tipo ".$tipo." o campo área de edificação deve ser maior que Zero");;
                }
                break;
            case 'Apartamento':
                if($valor <= 0){
                    $fail("Para o tipo ".$tipo." o campo área de edificação deve ser maior que Zero");;
                }
                break;
            default:
                break;
        }
    }
}
