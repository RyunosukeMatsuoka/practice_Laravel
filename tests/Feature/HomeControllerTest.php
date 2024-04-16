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
}
