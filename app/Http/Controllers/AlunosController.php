<?php

namespace App\Http\Controllers;

// use App\Models\User;
use App\Models\Aluno;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AlunosController extends Controller
{
    public function index()
    {
        // $s = 'string';
        // dd($s);
        return Inertia::render('Alunos/Index', [
            'filters' => Request::all('search', 'type', 'trashed'),
            'alunos' => Auth::user()->account->alunos()
                ->orderByName()
                ->filter(Request::only('search', 'type', 'trashed'))
                ->get()
                ->transform(fn ($aluno) => [
                    'id' => $aluno->id,
                    'name' => $aluno->name,
                    'email' => $aluno->email,
                    'photo' => $aluno->photo_path ? URL::route('image', ['path' => $aluno->photo_path, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
                    'deleted_at' => $aluno->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Alunos/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('alunos')],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
        ]);

        Auth::user()->account->alunos()->create([
            'name' => Request::get('name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'photo_path' => Request::file('photo') ? Request::file('photo')->store('alunos') : null,
        ]);

        return Redirect::route('alunos')->with('success', 'Aluno created.');
    }

    public function edit(Aluno $aluno)
    {
        return Inertia::render('Alunos/Edit', [
            'aluno' => [
                'id' => $aluno->id,
                'name' => $aluno->name,
                'email' => $aluno->email,
                'photo' => $aluno->photo_path ? URL::route('image', ['path' => $aluno->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
                'deleted_at' => $aluno->deleted_at,
            ],
        ]);
    }

    public function update(Aluno $aluno)
    {
        if (App::environment('demo') && $aluno->isDemoUser()) {
            return Redirect::back()->with('error', 'Updating the demo aluno is not allowed.');
        }

        Request::validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('alunos')->ignore($aluno->id)],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
        ]);

        $aluno->update(Request::only('name','email', 'owner'));

        if (Request::file('photo')) {
            $aluno->update(['photo_path' => Request::file('photo')->store('alunos')]);
        }

        if (Request::get('password')) {
            $aluno->update(['password' => Request::get('password')]);
        }

        return Redirect::back()->with('success', 'Aluno updated.');
    }

    public function destroy(Aluno $aluno)
    {

        $aluno->delete();

        return Redirect::back()->with('success', 'Aluno deleted.');
    }

    public function restore(Aluno $aluno)
    {
        $aluno->restore();

        return Redirect::back()->with('success', 'Aluno restored.');
    }
}
