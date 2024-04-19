<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_signUp_and_is_redirected_to_showLogin()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect(route('showLogin'));
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    public function test_guest_user_is_redirected_to_loginPage()
    {
        $response = $this->get('/myArticles/1');

        $response->assertRedirect('/signIn');
    }

    public function test_user_can_login_and_is_redirected_to_ownArticles()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/signIn/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/myArticles/'. $user->id);
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_with_invalid_credentials_cannot_login()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/signIn/login', [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ]);

        $response->assertSessionHasErrors('login_error');
        $this->assertGuest();
    }
}
