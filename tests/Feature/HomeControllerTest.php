<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Article_tag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_see_articles_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);

        $response->assertSee('Global Feed');
        $response->assertSee('New Article');
        $response->assertSee('Your Feed');
    }

    public function test_unauthenticated_user_can_see_articles_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('Global Feed');
        $response->assertDontSee('New Article');
        $response->assertDontSee('Your Feed');
    }

    public function test_all_user_can_see_article_detail_page()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/article/' . $article->id);

        $response->assertStatus(200);

        $response->assertSee($user->name);
        $response->assertSee($article->title);
        $response->assertSee($article->content);
    }

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

        $response->assertRedirect('/myArticles/'.$user->id);
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
