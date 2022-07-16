<?php

use App\Http\Livewire\Admin;
use App\Http\Livewire\Categoria;
use App\Http\Livewire\Configuracao;
use App\Http\Livewire\Ferramenta;
use App\Http\Livewire\FluxoCaixa;
use App\Http\Livewire\FormaPagamento;
use App\Http\Livewire\Home;
use App\Http\Livewire\Notificacao;
use App\Http\Livewire\Relatorio;
use App\Http\Livewire\Retirada;
use App\Http\Livewire\Senha;
use App\Http\Livewire\Shortcut;
use App\Http\Livewire\Tarefa;
use App\Http\Livewire\UserComissao;
use App\Http\Livewire\UserContrato;
use App\Http\Livewire\VisaoGeral;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function(){

    Route::get('/', Home::class)->name('home');
    Route::get('/caixa', FluxoCaixa::class)->name('caixa');
    Route::get('/retiradas', Retirada::class)->name('retiradas');
    Route::get('/geral', VisaoGeral::class)->name('geral');
    Route::get('/relatorios', Relatorio::class)->name('relatorios');
    Route::get('/categorias', Categoria::class)->name('categorias');
    Route::get('/links', Shortcut::class)->name('links');
    Route::get('/ferramentas', Ferramenta::class)->name('ferramentas');
    Route::get('/tarefas', Tarefa::class)->name('tarefas');
    Route::get('/configuracoes', Configuracao::class)->name('configuracoes');
    Route::get('/admin', Admin::class)->name('admin');
    Route::get('/meus-contratos', UserContrato::class)->name('meus-contratos');
    Route::get('/minhas-comissoes', UserComissao::class)->name('minhas-comissoes');
    Route::get('/notificacoes', Notificacao::class)->name('notificacoes');
    Route::get('/formas-pagamento', FormaPagamento::class)->name('formas-pagamento');
    Route::get('/gerenciador-de-senhas', Senha::class)->name('gerenciador-de-senhas');
    
});

Route::get('/opt', function() {
    Artisan::call('optimize');
    return "Cleared";
});