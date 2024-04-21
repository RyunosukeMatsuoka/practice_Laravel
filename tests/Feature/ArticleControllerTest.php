<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;
use App\Models\Tag;
use App\Models\User;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_article_detail_page()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/article/' . $article->id);

        $response->assertStatus(200);

        $response->assertSee($user->name);
        $response->assertSee($article->title);
        $response->assertSee($article->content);
    }

    public function test_authenticated_user_can_create_article_and_is_redirected_to_articles()
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->create();

        $articleData = [
            'title' => 'Test Article',
            'outline' => 'This is a test article',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'tags' => $tag->name,
        ];

        $response = $this->actingAs($user)->post(route('store'), $articleData);

        $response->assertRedirect(route('articles'));
        $this->assertDatabaseHas('articles', [
            'title' => $articleData['title'],
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('article_tags', [
            'tag_id' => $tag->id,
        ]);
    }

    public function test_authenticated_user_can_edit_article_and_is_redirected_to_articles()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $tag = Tag::factory()->create();
        $article->tags()->attach($tag->id);

        $updatedArticleData = [
            'title' => 'Updated Test Article',
            'outline' => 'This is an updated test article',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Updated.',
            'tags' => $tag->name,
        ];

        $response = $this->actingAs($user)->put(route('update', $article->id), $updatedArticleData);

        $response->assertRedirect(route('articles'));
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => $updatedArticleData['title'],
        ]);
        $this->assertDatabaseHas('article_tags', [
            'article_id' => $article->id,
            'tag_id' => $tag->id,
        ]);
    }

    public function test_authenticated_user_can_delete_article_and_is_redirected_to_articles()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create(['user_id' => $user->id]);
        $tag = Tag::factory()->create();
        $article->tags()->attach($tag->id);

        $response = $this->actingAs($user)->delete(route('delete', $article->id));

        $response->assertRedirect(route('articles'));
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
        $this->assertDatabaseMissing('article_tags', [
            'article_id' => $article->id,
            'tag_id' => $tag->id,
        ]);
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }
}
