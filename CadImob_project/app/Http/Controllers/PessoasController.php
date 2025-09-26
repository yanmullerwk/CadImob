<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoasRequest;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Ramsey\Uuid\v1;

class PessoasController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::all();

        return Inertia::render('Pessoas/PessoasPage', [
            'pessoas' => $pessoas,
        ]);
    }

    public function create(){
        return Inertia::render('Pessoas/PessoasCadastroPage');
    }

    public function store(StorePessoasRequest $request){//fazer o request especifico para validar
        $pessoa = $request->validated();
        Pessoa::create($pessoa);
    }

    public function edit($id){
        $pessoa = Pessoa::findOrFail($id);
        return Inertia::render('Pessoas/PessoasEditPage', ['pessoa'=>$pessoa]);
    }

    
}
