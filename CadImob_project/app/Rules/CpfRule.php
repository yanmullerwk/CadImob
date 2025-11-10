<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         // Remove tudo que não for número (pontos, traços, espaços etc.)
        $cpfNumeros = preg_replace('/\D/', '', $value);
        // Se o CPF não tiver exatamente 11 dígitos, já é inválido
        if (strlen($cpfNumeros) !== 11) {
            $fail("O campo {$attribute} deve ter 11 dígitos.");
            return;
        }

        // Chama a função que faz a verificação real do CPF
        if (!$this->verifyCPF($cpfNumeros)) {
            $fail("O {$attribute} informado é inválido.");
        }
    }

    private function verifyCPF($cpf){
        // Verifica se todos os dígitos são iguais (ex: 11111111111)
        // Esse tipo de CPF é considerado inválido
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Loop para validar os dois dígitos verificadores do CPF
        // O CPF é composto por 9 dígitos base + 2 dígitos verificadores
        for ($tamanhoBase = 9; $tamanhoBase < 11; $tamanhoBase++) {

            // Soma acumuladora para calcular o dígito verificador
            $soma = 0;

            // Faz o cálculo com base nos primeiros dígitos do CPF
            for ($indice = 0; $indice < $tamanhoBase; $indice++) {
                // Multiplica cada dígito por um peso decrescente
                // Exemplo: no primeiro dígito verificador, pesos são 10,9,8,7...
                $peso = ($tamanhoBase + 1) - $indice;
                $soma += $cpf[$indice] * $peso;
            }

            // Calcula o resto da divisão para achar o dígito verificador
            $resto = ((10 * $soma) % 11) % 10;

            // Verifica se o dígito encontrado bate com o do CPF informado
            if ($cpf[$indice] != $resto) {
                return false;
            }

          }

        // Se passou pelos dois testes, o CPF é válido
        return true;
    }
}
