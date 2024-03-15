<?php

namespace App\Http\Controllers;

// use App\Models\User;
use App\Models\Professor;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfessoresController extends Controller
{
    public function index()
    {
        // $s = 'string';
        // dd($s);
        return Inertia::render('Professores/Index', [
            'filters' => Request::all('search', 'type', 'trashed'),
            'professores' => Auth::user()->account->professores()
                ->orderByName()
                ->filter(Request::only('search', 'type', 'trashed'))
                ->get()
                ->transform(fn ($professor) => [
                    'id' => $professor->id,
                    'name' => $professor->name,
                    'email' => $professor->email,
                    'photo' => $professor->photo_path ? URL::route('image', ['path' => $professor->photo_path, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
                    'deleted_at' => $professor->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Professores/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('professores')],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
        ]);

        Auth::user()->account->professores()->create([
            'name' => Request::get('name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'photo_path' => Request::file('photo') ? Request::file('photo')->store('professores') : null,
        ]);

        return Redirect::route('professores')->with('success', 'Professor created.');
    }

    public function edit(Professor $professor)
    {
        return Inertia::render('Professores/Edit', [
            'professor' => [
                'id' => $professor->id,
                'name' => $professor->name,
                'email' => $professor->email,
                'photo' => $professor->photo_path ? URL::route('image', ['path' => $professor->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
                'deleted_at' => $professor->deleted_at,
            ],
        ]);
    }

    public function update(Professor $professor)
    {
        if (App::environment('demo') && $professor->isDemoUser()) {
            return Redirect::back()->with('error', 'Updating the demo professor is not allowed.');
        }

        Request::validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('professores')->ignore($professor->id)],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
        ]);

        $professor->update(Request::only('name','email', 'owner'));

        if (Request::file('photo')) {
            $professor->update(['photo_path' => Request::file('photo')->store('professores')]);
        }

        if (Request::get('password')) {
            $professor->update(['password' => Request::get('password')]);
        }

        return Redirect::back()->with('success', 'Professor updated.');
    }

    public function destroy(Professor $professor)
    {

        $professor->delete();

        return Redirect::back()->with('success', 'Professor deleted.');
    }

    public function restore(Professor $professor)
    {
        $professor->restore();

        return Redirect::back()->with('success', 'Professor restored.');
    }
}
