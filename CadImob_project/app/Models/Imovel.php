<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Imovel extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $table = 'imoveis';
    
    protected $fillable = [
       'tipo', 'areaTerreno', 'areaEdificacao', 'logradouro', 'numero', 'bairro', 'complemento', 'contribuinte_id', 'situacao'
    ];

    public function contribuinte(){
        return $this->belongsTo(Pessoa::class, 'contribuinte_id');
    }

    public function documents(){
        return $this->hasMany(Document::class, 'id');
    }

    public function averbacoes(){
        return $this->hasMany(Averbacao::class, 'id');
    }
}
