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

    // Converte a data_nascimento para um objeto de data automaticamente
    protected $casts = [
        'dataNascimento' => 'date:d-m-Y',
    ];

}
