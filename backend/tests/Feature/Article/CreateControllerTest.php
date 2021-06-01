<?php

namespace Tests\Feature\Article;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $password = 'password';
    protected $tags;

    public function setUp(): void
    {
        parent::setUp();
        $this->tags = Tag::factory()->count(5)->create();
    }

    public function test_create_page()
    {
        // ログインしていない場合
        $response = $this->get(route('articles.create'));
        $response->assertStatus(302)
            ->assertRedirect('/login');

        // ログインしている場合
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('articles.create'));
        $response->assertStatus(200)
            ->assertSee('Article New');
    }
}
