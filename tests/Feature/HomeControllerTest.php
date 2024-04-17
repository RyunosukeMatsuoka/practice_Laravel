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
        $this->actingAs($user);

        $articles = Article::factory(10)->create();
        $tags = Tag::factory(5)->create();
        // $article_tags = Article_tag::factory(5)->create();
        // $users = User::factory(3)->create();

        $response = $this->get(route('articles'));

        $response->assertStatus(200);
        $response->assertViewIs('conduit.home');

        foreach ($articles as $article) {
            $response->assertSee($article->title);
            $response->assertSee($article->outline);
        }

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }

    public function test_unauthenticated_user_can_see_articles_page()
    {
        // $users = User::factory(3)->create();
        $this->actingAs(User::factory()->create(), 'web');
        $articles = Article::factory(10)->create();
        $tags = Tag::factory(5)->create();
        // $article_tags = Article_tag::factory(5)->create();

        $response = $this->get(route('articles'));

        $response->assertStatus(200);
        $response->assertViewIs('conduit.Unauth_home');

        foreach ($articles as $article) {
            $response->assertSee($article->title);
            $response->assertSee($article->outline);
        }

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }

        /* foreach ($users as $user) {
            $response->assertSee($user->name);
        } */
    }

    public function test_authenticated_user_can_access_tag_page()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = Tag::factory()->create();
        // $articles = Article::factory()->count(5)->create();
        /* $article_tags = [];
        foreach ($articles as $article) {
            $article_tags[] = Article_tag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $tag->id,
            ]);
        } */
        $users = User::factory()->count(5)->create();

        // Act
        $response = $this->get(route('sortArticles', ['id' => $tag->id]));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('conduit.home_tag');
        $response->assertViewHas('articles');
        $response->assertViewHas('article_tags');
        $response->assertViewHas('tag', $tag);
        $response->assertViewHas('tags', Tag::all());
        $response->assertViewHas('users', $users);
    }

    public function test_unauthenticated_user_can_access_tag_page()
    {
        $tag = Tag::factory()->create();
        $articles = Article::factory()->count(5)->create();
        /* $article_tags = [];
        foreach ($articles as $article) {
            $article_tags[] = Article_tag::factory()->create([
                'article_id' => $article->id,
                'tag_id' => $tag->id,
            ]);
        } */
        $users = User::factory()->count(5)->create();

        $response = $this->get(route('sortArticles', ['id' => $tag->id]));

        $response->assertStatus(200);
        $response->assertViewIs('conduit.Unauth_home_tag');
        $response->assertViewHas('articles', $articles);
        $response->assertViewHas('article_tags');
        $response->assertViewHas('tag', $tag);
        $response->assertViewHas('tags', Tag::all());
        $response->assertViewHas('users', $users);
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
        $user = User::factory()->create([
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
