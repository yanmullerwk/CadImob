<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
 
class Pessoa extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    // Campos que podem ser preenchidos em massa (security first!)
    protected $fillable = [
        'nome', 'dataNascimento', 'cpf', 'sexo', 'telefone', 'email',
    ];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class);
    }

}
