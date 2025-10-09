<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    use HasFactory;

    protected $table = 'imoveis';
    
    protected $fillable = [
       'tipo', 'areaTerreno', 'areaEdificacao', 'logradouro', 'numero', 'bairro', 'complemento', 'contribuinte_id', 'situacao'
    ];

    public function contribuinte(){
        return $this->belongsTo(Pessoa::class, 'contribuinte_id');
    }
}
