<?php

namespace App\Http\Controllers;

use App\Models\Averbacao;
use App\Models\Imovel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AverbacoesController extends Controller
{
   public function create($id){
     $imovel = Imovel::findOrFail($id);

     return Inertia::render('Averbacao/AverbacaoCadastroPage', ['imovel'=>$imovel]);
   } 

   public function store(Request $request)
{
    $validated = $request->validate([
        'imovel_id' => ['required', 'exists:imoveis,id'], // tabela correta: 'imoveis'
        'eventType' => ['required', 'string'],
        'measure' => ['nullable', 'numeric'],
        'description' => ['nullable', 'string'],
    ]);

    DB::beginTransaction();

    try {
        $averbacao = Averbacao::create($validated);
        $imovel = Imovel::findOrFail($validated['imovel_id']);

        $event = $validated['eventType'];
        $measure = $validated['measure'];
        $imovelType = $imovel->tipo;
        $areaAtual = $imovel->areaEdificacao;
        $areaTerreno = $imovel->areaTerreno;
        $situacaoAtual = $imovel->situacao;

        if ($event === 'Cancelamento') {
            if ($situacaoAtual === 'INATIVO') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'eventType' => "Não é possível desativar um imóvel que já está inativo."
                ]);
            }
            $imovel->update(['situacao' => 'INATIVO']);
        } elseif ($event === 'Aumento' && $measure) {
            $areaAmpliada = $areaAtual + $measure;
            if($imovelType === 'Terreno'){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'eventType' => "Não é possível aumentar a area de edificação de um terreno."
                ]);
            }
            if($areaAmpliada > $areaTerreno){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'eventType' => "Não é possível deixar a area de edificação maior que o terreno"
                ]);
            }
            $imovel->update(['areaEdificacao' => $areaAmpliada]);
        } elseif ($event === 'Reducao' && $measure) {
            if($imovelType === 'Terreno'){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'eventType' => "Não é possível reduzir a area de edificação de um terreno."
                ]);
            }

            $imovel->update(['areaEdificacao' => max(0, $areaAtual - $measure)]);
        } elseif ($event === 'Reativacao') {
            if($situacaoAtual === 'ATIVO'){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'eventType' => "Não é possível desativar um imóvel que já está inativo."
                ]);
            }
            $imovel->update(['situacao' => 'ATIVO']);
        }

        DB::commit();
        return back()->with('success', 'Averbação cadastrada e imóvel atualizado com sucesso!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['general' => 'Erro ao processar: ' . $e->getMessage()]);
    }
}
}
