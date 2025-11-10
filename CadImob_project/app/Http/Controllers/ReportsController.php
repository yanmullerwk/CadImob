<?php

namespace App\Http\Controllers;

use App\Models\Averbacao;
use App\Models\Imovel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function syntheticReport(){
        $imoveis = Imovel::with("contribuinte")->get();
        
        $pdf = Pdf::loadView('Reports.SyntheticReport', ['imoveis' => $imoveis ]);  
        return $pdf->download('RelatorioImoveis.pdf');
    }

    public function individualReport($id){
        $imovel = Imovel::findOrFail($id);
        $averbacoes = Averbacao::where('imovel_id', $id)->get();
        $pdf = Pdf::loadView('Reports.IndividualReport', ['imovel' => $imovel, 'averbacoes'=> $averbacoes]);
        return $pdf->download('RelatorioImovel.pdf');
    }
}
