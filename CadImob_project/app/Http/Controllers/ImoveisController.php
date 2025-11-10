<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImoveisRequest;
use App\Http\Requests\UpdateImoveisRequest;
use App\Http\Requests\uploadFileRequest;
use App\Models\Averbacao;
use App\Models\Document;
use App\Models\Imovel;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ImoveisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imoveis = Imovel::with('contribuinte')->paginate(5);

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
        
        
        $imovelCreated = Imovel::create($imoveis);

        if($request->hasFile('documents')){
            foreach($request->file('documents') as $document){
                $caminhoArquivo = $document->store("documentos/{$imovelCreated->id}", 'public');

                Document::create([
                    'nomeArquivo'=> $document->getClientOriginalName(),
                    'caminhoDoArquivo'=>$caminhoArquivo,
                    'imovel_id'=> $imovelCreated->id,
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pessoas = Pessoa::all();
        $imovel = Imovel::findOrFail($id);
        $documents = Document::where('imovel_id', $id)->get();
        
        $averbacoes = Averbacao::where('imovel_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(5) // muda esse número se quiser mais/menos por página
        ->through(fn($av) => [
            'id' => $av->id,
            'eventType' => $av->EventType,
            'measure' => $av->measure,
            'description' => $av->description,
            'data' => \Carbon\Carbon::parse($av->data)->format('d/m/Y'),
        ]);

        return Inertia::render('Imoveis/ImoveisEditPage', ['imovel'=>$imovel, 'pessoas' => $pessoas, 'documents' => $documents, 'averbacoes' => $averbacoes,]);
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

    public function uploadFile(uploadFileRequest $request, $id){
        if($request->hasFile('documents')){
            foreach($request->file('documents') as $document){
                $caminhoArquivo = $document->store("documentos/{$id}", 'public');

                Document::create([
                    'nomeArquivo'=> $document->getClientOriginalName(),
                    'caminhoDoArquivo'=>$caminhoArquivo,
                    'imovel_id'=> $id,
                ]);
            }
        }
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

    public function destroyDocument(Document $document){
        Storage::delete($document->caminhoDoArquivo);
        $document->delete();

        return back()->with('success', 'Documento excluído com sucesso.');
    }

    public function downloadFile($id){
        $document = Document::findOrFail($id);


        
        if (!Storage::disk('public')->exists($document->caminhoDoArquivo)) {
            abort(404, 'Arquivo não encontrado.');
        }

        
        return Storage::download($document->caminhoDoArquivo, $document->nomeArquivo);
    }
}
