<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => Hash::make('Admin@2025'),
            'role'     => 'super_admin',
            'active'   => true,
        ]);
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'Admin@2025',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['access_token', 'token_type', 'expires_in', 'user']);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Email ou mot de passe incorrect.']);
    }

    public function test_login_fails_for_inactive_user(): void
    {
        $this->admin->update(['active' => false]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => 'admin@test.com',
            'password' => 'Admin@2025',
        ]);

        $response->assertStatus(403);
    }

    public function test_me_returns_authenticated_user(): void
    {
        $token = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->getJson('/api/auth/me')
             ->assertStatus(200)
             ->assertJsonPath('data.email', 'admin@test.com');
    }

    public function test_me_fails_without_token(): void
    {
        $this->getJson('/api/auth/me')->assertStatus(401);
    }

    public function test_admin_can_logout(): void
    {
        $token = auth('api')->login($this->admin);

        $this->withHeader('Authorization', "Bearer {$token}")
             ->postJson('/api/auth/logout')
             ->assertStatus(200)
             ->assertJson(['message' => 'Déconnexion réussie.']);
    }
}
