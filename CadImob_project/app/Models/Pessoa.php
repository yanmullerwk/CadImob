<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pessoa extends Model
{
     use HasFactory;

    // Campos que podem ser preenchidos em massa (security first!)
    protected $fillable = [
        'nome', 'dataNascimento', 'cpf', 'sexo', 'telefone', 'email',
    ];

    public function imoveis()
    {
        return $this->hasMany(Imovel::class, 'contribuinte_id');
    }

}
