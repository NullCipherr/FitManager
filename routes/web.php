<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\AvaliacoesController;
use App\Http\Controllers\RegistrationController;

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

// Route::get('/', [HomeController::class, 'index']);


// Register

Route::get('register', [RegistrationController::class, 'create'])
    ->name('register')
    ->middleware('guest');

Route::post('register', [RegistrationController::class, 'store'])
    ->name('register.store')
    ->middleware('guest');


// Login

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');


// Alunos

Route::get('alunos', [AlunosController::class, 'index'])
    ->name('alunos')
    ->middleware('auth');

Route::get('alunos/create', [AlunosController::class, 'create'])
    ->name('alunos.create')
    ->middleware('auth');

Route::post('alunos', [AlunosController::class, 'store'])
    ->name('alunos.store')
    ->middleware('auth');

Route::get('alunos/{aluno}/edit', [AlunosController::class, 'edit'])
    ->name('alunos.edit')
    ->middleware('auth');

Route::put('alunos/{aluno}', [AlunosController::class, 'update'])
    ->name('alunos.update')
    ->middleware('auth');

Route::delete('alunos/{aluno}', [AlunosController::class, 'destroy'])
    ->name('alunos.destroy')
    ->middleware('auth');

Route::put('alunos/{aluno}/restore', [AlunosController::class, 'restore'])
    ->name('alunos.restore')
    ->middleware('auth');

// Avaliações

Route::get('avaliacoes', [AvaliacoesController::class, 'index'])
->name('avaliacoes')
->middleware('auth');

Route::get('avaliacoes/create', [AvaliacoesController::class, 'create'])
->name('avaliacoes.create')
->middleware('auth');

Route::post('avaliacoes', [AvaliacoesController::class, 'store'])
->name('avaliacoes.store')
->middleware('auth');

Route::get('avaliacoes/{avaliacao}/edit', [AvaliacoesController::class, 'edit'])
->name('avaliacoes.edit')
->middleware('auth');

Route::put('avaliacoes/{avaliacao}', [AvaliacoesController::class, 'update'])
->name('avaliacoes.update')
->middleware('auth');

Route::delete('avaliacoes/{avaliacao}', [AvaliacoesController::class, 'destroy'])
->name('avaliacoes.destroy')
->middleware('auth');

Route::put('avaliacoes/{avaliacao}/restore', [AvaliacoesController::class, 'restore'])
->name('avaliacoes.restore')
->middleware('auth');