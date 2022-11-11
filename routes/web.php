<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['role:user']], function () {
    Route::prefix('user')->group(function () {

        // RELATÓRIO SEARCH
        Route::post('/transacoes_aguardando/confirmar', [App\Http\Controllers\User\TransacoesAguardandoController::class, 'confirmar']);

        // RELATÓRIO SEARCH
        Route::post('/transacoes_aguardando/delete', [App\Http\Controllers\User\TransacoesAguardandoController::class, 'delete']);

        // RELATÓRIO SEARCH
        Route::get('/transacoes_aguardando', [App\Http\Controllers\User\TransacoesAguardandoController::class, 'index']);

        // RELATÓRIO SEARCH
        Route::post('/transacoes_recorrentes/update', [App\Http\Controllers\User\TransacaoRecorrenteController::class, 'update']);

        // RELATÓRIO SEARCH
        Route::post('/transacoes_recorrentes/delete', [App\Http\Controllers\User\TransacaoRecorrenteController::class, 'delete']);

        // RELATÓRIO SEARCH
        Route::post('/transacoes_recorrentes/store', [App\Http\Controllers\User\TransacaoRecorrenteController::class, 'store']);

        // RELATÓRIO SEARCH
        Route::get('/transacoes_recorrentes', [App\Http\Controllers\User\TransacaoRecorrenteController::class, 'index']);

        // RELATÓRIO SEARCH
        Route::post('/relatorio/search', [App\Http\Controllers\User\RelatorioController::class, 'search']);

        // RELATÓRIO
        Route::get('/relatorio', [App\Http\Controllers\User\RelatorioController::class, 'index']);

        // TRANSAÇÕES STORE
        Route::post('/transacoes/store', [App\Http\Controllers\User\TransacaoController::class, 'store']);

        // VENDAS STORE
        Route::post('/vendas/store', [App\Http\Controllers\User\VendaController::class, 'store']);

        // PRODUTOS ALL
        Route::get('/produtos/all', [App\Http\Controllers\User\ProdutoController::class, 'all']);

        // PRODUTOS STORE
        Route::post('/produtos/store', [App\Http\Controllers\User\ProdutoController::class, 'store']);

        // PRODUTOS
        Route::get('/produtos', [App\Http\Controllers\User\ProdutoController::class, 'index']);

        // PROJETOS ALL
        Route::get('/projetos/all', [App\Http\Controllers\User\ProjetoController::class, 'all']);

        // PROJETOS STORE
        Route::post('/projetos/store', [App\Http\Controllers\User\ProjetoController::class, 'store']);

        // PROJETOS
        Route::get('/projetos', [App\Http\Controllers\User\ProjetoController::class, 'index']);

        // CATEGORIAS STORE
        Route::post('/categorias/store', [App\Http\Controllers\User\CategoriaController::class, 'store']);

        // CATEGORIAS
        Route::get('/categorias', [App\Http\Controllers\User\CategoriaController::class, 'index']);

        // RELATORIO
        Route::post('/leads/status/update', [App\Http\Controllers\User\LeadsController::class, 'atualizarStatus']);

        // RELATORIO
        Route::get('/relatorio', [App\Http\Controllers\User\RelatorioController::class, 'index']);

        // LEAD AVALIAR
        Route::post('/leads/avaliar', [App\Http\Controllers\User\LeadsController::class, 'avaliar']);

        // LEAD CREATE
        Route::post('/leads/store', [App\Http\Controllers\User\LeadsController::class, 'store']);

        // INDEX
        Route::get('/dashboard', [App\Http\Controllers\User\UserController::class, 'index'])->name('user.index');
    });
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('admin')->group(function () {

        // RELATÓRIO
        Route::post('/ranking/search', [App\Http\Controllers\Admin\RelatorioController::class, 'searchRanking']);

        // RANKING
        Route::get('/ranking', [App\Http\Controllers\Admin\RelatorioController::class, 'ranking']);

        // RELATÓRIO
        Route::post('/relatorio/search', [App\Http\Controllers\Admin\RelatorioController::class, 'search']);

        // RELATÓRIO
        Route::get('/relatorio', [App\Http\Controllers\Admin\RelatorioController::class, 'index']);

        // ENCAMINHAR LEAD
        Route::post('/leads/encaminhar', [App\Http\Controllers\Admin\LeadsController::class, 'encaminhar']);

        // RELATÓRIO POR LIDER
        Route::post('/users/search-by-role', [App\Http\Controllers\Admin\UsersController::class, 'searchByRole']);

        // UPDATE USERS
        Route::post('/users/update', [App\Http\Controllers\Admin\UsersController::class, 'update']);

        // CREATE USERS
        Route::post('/users/create', [App\Http\Controllers\Admin\UsersController::class, 'store']);

        // ONLY CREATE USERS
        Route::post('/users/delete', [App\Http\Controllers\Admin\UsersController::class, 'delete']);

        // ONLY CREATE USERS
        Route::get('/users/new-create', [App\Http\Controllers\Admin\UsersController::class, 'newcreate']);

        // INDEX
        Route::get('/users/list', [App\Http\Controllers\Admin\UsersController::class, 'list'])->name('admin.users.list');

        // INDEX
        Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');
    });
});

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');

Route::get('/teste', function () {
    return view('teste');
});

Route::get('/list', function () {
    return view('list');
});

Route::get('/backoffice', function () {
    return view('new');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/corretor/{telefone}', [App\Http\Controllers\CorretorController::class, 'index'])->name('corretor.controller');
Route::post('/corretor/avaliar', [App\Http\Controllers\CorretorController::class, 'avaliar']);


Route::group(['middleware' => 'auth'], function () {
    Route::get('/senha', [App\Http\Controllers\VerificaTrocaSenhaController::class, 'index'])->name('senha');
    Route::post('/updatesenha', [App\Http\Controllers\VerificaTrocaSenhaController::class, 'updatesenha']);
});
