<?php

use App\Http\Livewire\Categoria;
use App\Http\Livewire\FluxoCaixa;
use App\Http\Livewire\Home;
use App\Http\Livewire\Relatorio;
use App\Http\Livewire\Retirada;
use App\Http\Livewire\VisaoGeral;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', Home::class)->name('home');
    Route::get('/caixa', FluxoCaixa::class)->name('caixa');
    Route::get('/retiradas', Retirada::class)->name('retiradas');
    Route::get('/geral', VisaoGeral::class)->name('geral');
    Route::get('/relatorios', Relatorio::class)->name('relatorios');
    Route::get('/categorias', Categoria::class)->name('categorias');
    
});

Route::get('/opt', function() {
    Artisan::call('optimize');
    return "Cleared";
});