<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Averbacao extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $table = 'averbacoes';

    protected $fillable = [
        'imovel_id', 'eventType', 'measure', 'description', 'data'
    ];

    public function imoveis(){
        return $this->belongsTo(Imovel::class);
    }
}
