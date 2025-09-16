<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PessoasController extends Controller
{
    public function index(){
        return Inertia::render('Pessoas/TabelaPessoas',['test'=>$test]);
    }
}
