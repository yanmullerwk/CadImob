<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Ramsey\Uuid\v1;

class PessoasController extends Controller
{
    public function index()
    {
        // Dados fictícios, como se tivessem sido buscados no banco de dados
        $pessoas = [
            [
                'id' => 1,
                'nome' => 'Ana Paula',
                'cpf' => '123.456.789-01'
            ],
            [
                'id' => 2,
                'nome' => 'João Silva',
                'cpf' => '987.654.321-09'
            ],
            [
                'id' => 3,
                'nome' => 'Maria Oliveira',
                'cpf' => '111.222.333-44'
            ],
           
        ];

        // O Inertia é o elo de ligação.
        // Ele renderiza a página 'Dashboard.vue' e passa o array de 'pessoas' como um 'prop'.
        return Inertia::render('Pessoas/PessoasPage', [
            'pessoas' => $pessoas,
        ]);
    }

    function create(){
        return Inertia::render('Pessoas/PessoasCreatePage');
    }

    function store(Request $request){
        $pessoa = new Pessoa;
        $pessoa->nome = $request->nome;
        $pessoa->data_nascimento = $request->data_nascimento;
        $pessoa->cpf = $request->cpf;
        $pessoa->sexo = $request->sexo;
        $pessoa->telefone = $request->telefone;
        $pessoa->email = $request->email;

        $pessoa->save();
    }
}
