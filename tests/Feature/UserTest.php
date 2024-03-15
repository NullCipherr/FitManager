<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\Assert as InertiaAssert;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_users_index_requires_authentication()
    {
        $response = $this->get(route('users'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    // public function test_users_index_returns_users_list()
    // {
    // // Autentica um usuário para ter acesso à rota
    //     $user = \App\Models\User::factory()->create();
    //     Auth::login($user);

    //     // Cria alguns usuários de teste
    //     $users = \App\Models\User::factory()->count(3)->create();

    //     // Visita a rota 'users'
    //     $response = $this->get(route('users'));

    //     // Verifica se o status da resposta é 200
    //     $response->assertStatus(200);

    //     // Verifica se a resposta contém a propriedade 'users' com os dados dos usuários criados
    //     $response->assertViewHas('users');
    //     $response->assertViewHas('users', function ($value) use ($users) {
    //         return collect($value)->sortBy('id')->values()->toArray() === $users->sortBy('id')->values()->toArray();
    //     });
    // }

    public function test_users_index_renders_with_data()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get(route('users'));

        $response->assertStatus(200)
            ->assertInertia(function ($assert) use ($user) {
                $assert->component('Users/Index')
                    ->where('filters', Request::all('search', 'type', 'trashed'))
                    ->where('users', $user->account->users()
                        ->orderByName()
                        ->filter(Request::only('search', 'type', 'trashed'))
                        ->paginate(10)
                        ->withQueryString()
                        ->transform(function ($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                                'type' => $user->type,
                                'owner' => $user->owner,
                                'deleted_at' => $user->deleted_at,
                            ];
                        })->toArray()
                    );
            });
    }
}







    // public function test_users_route_returns_users()
    // {
    //     $user = \App\Models\User::factory()->create();
    //     // $this->actingAs($user);

    //     $response = $this->get(route('users'));

    //     $response->assertStatus(200);
    //     $response->assertInertiaViewIs('Users/Index');
    //     $response->assertPropCount('users', 1);
    //     $response->assertPropValue('users', function ($value) use ($user) {
    //         return $value[0]['id'] === $user->id;
    //     });
    // }
