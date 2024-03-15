<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Aluno;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_be_registered()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'cpf' => '12345678901',
            'password' => 'password',
            'account_id' => 1,
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Usuario registrado com sucesso');

        $this->assertCount(1, User::all());
        $this->assertCount(1, Aluno::all());

        $user = User::first();
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('12345678901', $user->cpf);
        $this->assertEquals('Aluno', $user->type);
        $this->assertEquals(1, $user->account_id);

        $aluno = Aluno::first();
        $this->assertEquals($user->id, $aluno->user_id);
        $this->assertEquals('Test User', $aluno->name);
        $this->assertEquals('12345678901', $aluno->cpf);
        $this->assertEquals('mensal', $aluno->plano);
        $this->assertEquals('test@example.com', $aluno->email);
    }
}