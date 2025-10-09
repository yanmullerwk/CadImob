<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImoveisController;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\ProfileController;
use App\Models\Imovel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
 

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Rota home
Route::get('/', [HomeController::class, 'index'])->name('home.index');
//Rotas Pessoas
Route::prefix('pessoas')->group(function(){
    Route::get('/', [PessoasController::class, 'index'])->name('pessoas.index');
    Route::get('/create', [PessoasController::class, 'create'])->name('pessoas.create');//leva pro meu forms
    Route::post('/',[PessoasController::class, 'store'])->name('pessoas.store')->middleware([HandlePrecognitiveRequests::class]);
    Route::put('/{id}', [PessoasController::class, 'update'])->name('pessoas.update')->middleware([HandlePrecognitiveRequests::class]);
    Route::get('/{id}/edit', [PessoasController::class, 'edit'])->name('pessoas.edit');
    Route::delete('/{id}', [PessoasController::class, 'destroy'])->name('pessoas.destroy');
});

//rotas imoveis

Route::prefix('imoveis')->group(function(){
    Route::get('/', [ImoveisController::class, 'index'])->name('imoveis.index');
    Route::get('/create', [ImoveisController::class, 'create'])->name('imoveis.create');
    Route::post('/', [ImoveisController::class, 'store'])->name('imoveis.store')->middleware([HandlePrecognitiveRequests::class]);
    Route::get('/{id}/edit', [ImoveisController::class, 'edit'])->name('imoveis.edit');
    Route::put('/{id}', [ImoveisController::class, 'update'])->name('imoveis.update')->middleware([HandlePrecognitiveRequests::class]);
    Route::delete('/{id}', [ImoveisController::class, 'destroy'])->name('imoveis.destroy');
});

require __DIR__.'/auth.php';
