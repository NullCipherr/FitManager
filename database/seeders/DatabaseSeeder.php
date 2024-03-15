<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Aluno;
use App\Models\Avaliacao;
use App\Models\Professor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'FitManager']);

        \App\Models\User::factory(1)->create([
            'name' => 'funcionario',
            'email' => 'funcionario@example.com',
            'email_verified_at' => now(),
            'password' => 'secret', // password
            'remember_token' => Str::random(10),
            'type' => 'Funcionario'

        ]);

        \App\Models\User::factory(1)->create(
            ['name' => 'aluno' ,
            'email' => 'aluno@example.com',
            'password' => 'secret',
            'password' => 'secret', // password
            'remember_token' => Str::random(10),
            'type' => 'Aluno'])
            ->each(function ($user) {
                $aluno = Aluno::factory()->create([
                    'account_id' => $user->account_id,
                    'name' => $user->name,
                    'user_id' => $user->id

                ]);
                $user->update(['aluno_id' => $aluno->id]);
        });

        \App\Models\User::factory(1)->create(
            ['name' => 'professor' ,
            'email' => 'professor@example.com',
            'password' => 'secret',
            'remember_token' => Str::random(10),
            'type' => 'Professor'])
            ->each(function ($user) {
                $professor = Professor::factory()->create([
                    'account_id' => $user->account_id,
                    'name' => $user->name,
                    'user_id' => $user->id

                ]);
                $user->update(['professor_id' => $professor->id]);
        });

        \App\Models\User::factory(10)->create(['type' => 'Aluno'])->each(function ($user) {
            $aluno = Aluno::factory()->create([
                'account_id' => $user->account_id,
                'name' => $user->name,
                'user_id' => $user->id

            ]);
            $user->update(['aluno_id' => $aluno->id]);
        });

        \App\Models\User::factory(10)->create(['type' => 'Funcionario']);
        \App\Models\User::factory(10)->create(['type' => 'Professor']);
        \App\Models\Avaliacao::factory(10)->create();
    }
}
