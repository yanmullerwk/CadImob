<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AverbacoesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImoveisController;
use App\Http\Controllers\PessoasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserController;
use App\Models\Averbacao;
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

// tudo abaixo só acessa logado
Route::middleware(['auth', 'isActivate'])->group(function () {

    // dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // perfil
    

    // home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    // pessoas
    Route::prefix('pessoas')->group(function(){
        Route::get('/', [PessoasController::class, 'index'])->name('pessoas.index')->middleware('profile:T,S,A');
        Route::get('/create', [PessoasController::class, 'create'])->name('pessoas.create')->middleware('profile:T,S,A');
        Route::post('/',[PessoasController::class, 'store'])->name('pessoas.store')->middleware([HandlePrecognitiveRequests::class])->middleware('profile:T,S,A');
        Route::put('/{id}', [PessoasController::class, 'update'])->name('pessoas.update')->middleware([HandlePrecognitiveRequests::class])->middleware('profile:T,S,A');
        Route::get('/{id}/edit', [PessoasController::class, 'edit'])->name('pessoas.edit')->middleware('profile:T,S,A');
        Route::delete('/{id}', [PessoasController::class, 'destroy'])->name('pessoas.destroy')->middleware('profile:T,S,A');
    });

    // imoveis
    Route::prefix('imoveis')->group(function(){
        Route::get('/', [ImoveisController::class, 'index'])->name('imoveis.index')->middleware('profile:T,S,A');
        Route::get('/create', [ImoveisController::class, 'create'])->name('imoveis.create')->middleware('profile:T,S,A');
        Route::post('/', [ImoveisController::class, 'store'])->name('imoveis.store')->middleware([HandlePrecognitiveRequests::class])->middleware('profile:T,S,A');
        Route::get('/{id}/edit', [ImoveisController::class, 'edit'])->name('imoveis.edit')->middleware('profile:T,S,A');
        Route::put('/{id}', [ImoveisController::class, 'update'])->name('imoveis.update')->middleware([HandlePrecognitiveRequests::class])->middleware('profile:T,S,A');
        Route::delete('/{id}', [ImoveisController::class, 'destroy'])->name('imoveis.destroy')->middleware('profile:T,S,A');
        Route::delete('documents/{document}', [ImoveisController::class, 'destroyDocument'])->name('documents.destroy')->middleware('profile:T,S,A');
        Route::post('/{id}', [ImoveisController::class, 'uploadFile'])->name('documents.upload')->middleware('profile:T,S,A');
        Route::get('documents/{id}', [ImoveisController::class, 'downloadFile'])->name('documents.download')->middleware('profile:T,S,A');

       
    });

    Route::prefix('user')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('profile:T,S');
        Route::get('/register', [UserController::class, 'create'])->name('user.create');
        Route::get('/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('profile:T,S');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update')->middleware('profile:T,S');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('profile:T,S');
        Route::post('/register', [UserController::class, 'store'])->name('user.store');
        Route::post('/{id}/toggle-activate', [UserController::class, 'toggleActivate'])->name('user.toggleActivate');
    });
    Route::prefix('averbacoes')->group(function(){
        Route::get('/{id}',[AverbacoesController::class, 'create'])->name('averbacao.create');
        Route::post('/', [AverbacoesController::class, 'store'])->name('averbacoes.store');
    });

    Route::prefix('reports')->group(function(){
        Route::get('/',[ReportsController::class, 'syntheticReport'])->name('report.synthetic');
        Route::get('/{id}',[ReportsController::class, 'individualReport'])->name('report.individual');
    });

    Route::prefix('auditoria')->group(function () {
        Route::get('/', [AuditController::class, 'index'])->name('auditoria.index')->middleware('profile:T,S,A');
        Route::get('/{id}', [AuditController::class, 'show'])->name('auditoria.show')->middleware('profile:T,S,A');
    });


});

require __DIR__.'/auth.php';