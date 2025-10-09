<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImoveisRequest;
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
    public function edit(Imovel $imovel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imovel $imovel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imovel $imovel)
    {
        // Buscar o item pelo ID
        $imovel = imovel::find($id);

        if (!$imovel) {
            return redirect()->back()->with('error', 'Item não encontrado.');
        }

        // Excluir
        $imovel->delete();

        return redirect()->back()->with('success', 'Item excluído com sucesso!');
    }
}
