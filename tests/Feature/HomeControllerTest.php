<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

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

    public function test_authenticated_user_can_see_articles_page_sorted_by_tag()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $tag = Tag::factory()->create();

        $articles = Article::factory(3)->create(['user_id' => $user->id]);
        foreach ($articles as $article) {
            $article->tags()->attach($tag->id);
        }

        $response = $this->get(route('sortArticles', ['id' => $tag->id]));

        $response->assertStatus(200);
        $response->assertSee($tag->name);
        foreach ($articles as $article) {
            $response->assertSee($article->title);
        }
    }

    public function test_unauthenticated_user_can_see_articles_page_sorted_by_tag()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $articles = Article::factory(3)->create(['user_id' => $user->id]);
        foreach ($articles as $article) {
            $article->tags()->attach($tag->id);
        }

        $response = $this->get(route('sortArticles', ['id' => $tag->id]));

        $response->assertStatus(200);
        $response->assertSee($tag->name);
        foreach ($articles as $article) {
            $response->assertSee($article->title);
        }
    }

    public function test_authenticated_user_can_see_own_articles_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $articles = Article::factory(3)->create(['user_id' => $user->id]);

        $tag = Tag::factory()->create();
        foreach ($articles as $article) {
            $article->tags()->attach($tag->id);
        }

        $response = $this->get(route('ownArticles', ['user_id' => $user->id]));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        foreach ($articles as $article) {
            $response->assertSee($article->title);
        }
        $response->assertSee($tag->name);
    }
}
