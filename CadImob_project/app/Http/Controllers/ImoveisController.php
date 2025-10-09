<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImoveisRequest;
use App\Http\Requests\UpdateImoveisRequest;
use App\Models\Imovel;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImoveisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imoveis = Imovel::paginate(5);

        return Inertia::render('Imoveis/ImoveisPage', [
            'imoveis' => $imoveis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pessoas = Pessoa::all();
        return Inertia::render('Imoveis/ImoveisCadastroPage', ['pessoas' => $pessoas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImoveisRequest $request)
    {
        $imoveis = $request->validated();
    
        Imovel::create($imoveis);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pessoas = Pessoa::all();
        $imovel = Imovel::findOrFail($id);
        return Inertia::render('Imoveis/ImoveisEditPage', ['imovel'=>$imovel, 'pessoas' => $pessoas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImoveisRequest $request, $id)
    {
        $imovel = Imovel::findOrFail($id);

        $dados = $request->validated();

        // atualiza no banco
        $imovel->update($dados);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar o item pelo ID
        $imovel = Imovel::find($id);
        // Excluir
        $imovel->delete();
    }
}
