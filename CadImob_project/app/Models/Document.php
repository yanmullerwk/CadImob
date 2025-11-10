<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Document extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'imovel_id', 'nomeArquivo', 'caminhoDoArquivo'
    ];

    public function imoveis(){
        return $this->belongsTo(Imovel::class);
    }
}
