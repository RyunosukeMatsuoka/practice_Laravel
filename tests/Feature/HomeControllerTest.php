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

    public function test_authenticated_user_can_access_home_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // サンプルデータを入れてテストをしたい
        /* $articles = Article::factory()->count(5)->create();
        $article_tags = Article_tag::factory()->count(5)->create();
        $tags = Tag::factory()->count(5)->create();
        $users = User::factory()->count(5)->create(); */

        $response = $this->get(route('articles'));

        $response->assertStatus(200);
        $response->assertViewIs('conduit.home');

        $response->assertViewHas('articles');
        $response->assertViewHas('article_tags');
        $response->assertViewHas('tags');
        $response->assertViewHas('users');
        /* $response->assertViewHas('articles', $articles);
        $response->assertViewHas('article_tags', $article_tags);
        $response->assertViewHas('tags', $tags);
        $response->assertViewHas('users', $users); */
    }

    public function test_unauthenticated_user_can_access_home_page()
    {
        $response = $this->get(route('articles'));

        $response->assertStatus(200);
        $response->assertViewIs('conduit.Unauth_home');

        $response->assertViewHas('articles');
        $response->assertViewHas('article_tags');
        $response->assertViewHas('tags');
        $response->assertViewHas('users');
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
}
