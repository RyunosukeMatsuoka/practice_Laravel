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

    /* public function test_()
    {

    } */
}
