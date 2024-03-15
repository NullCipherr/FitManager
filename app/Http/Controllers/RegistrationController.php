<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aluno;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class RegistrationController extends Controller
{
    public function create()
    {
        return Inertia::render('Cadastro/Create');
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'cpf' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Criação do usuário
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'cpf' => request('cpf'),
            'password' => request('password'), 
            'type' => 'Aluno',
            'account_id' => 1, 
        ]);

        // Autenticação do usuário
        Auth::login($user);

        // Criação do aluno associado ao usuário
        $aluno = Aluno::create([
            'account_id' => $user->account_id,
            'user_id' => $user->id,
            'name' => $user->name,
            'cpf' => $user->cpf,
            'plano' => 'mensal',
            'email' => $user->email,
            'password' => $user->password,
        ]);

        // Atualização do usuário com o id do aluno
        $user->update(['aluno_id' => $aluno->id]);

        // Redirecionamento para a página inicial
        return Redirect::route('login')->with('success', 'Usuario registrado com sucesso');
    }
}