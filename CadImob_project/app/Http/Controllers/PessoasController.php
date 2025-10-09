<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoasRequest;
use App\Http\Requests\UpdatePessoasRequest;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Ramsey\Uuid\v1;

class PessoasController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::paginate(5);

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
        return Inertia::render('Pessoas/PessoaEditPage', ['pessoa'=>$pessoa]);
    }

    public function update(UpdatePessoasRequest $request, $id){
        $pessoa = Pessoa::findOrFail($id);
    
        // pega só os dados validados
        $dados = $request->validated();

        // atualiza no banco
        $pessoa->update($dados);
    }

    public function destroy($id){
        // Buscar o item pelo ID
        $pessoa = Pessoa::find($id);

        if (!$pessoa) {
            return redirect()->back()->with('error', 'Item não encontrado.');
        }

        // Excluir
        $pessoa->delete();

        return redirect()->back()->with('success', 'Item excluído com sucesso!');
    }

    
}
