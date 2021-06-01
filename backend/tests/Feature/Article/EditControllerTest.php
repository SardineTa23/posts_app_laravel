<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditControllerTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;
    protected Article $article;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->article = Article::factory()->create([
            'title' => 'article title',
            'body' => 'article body',
            'user_id' => $this->user->id
        ]);
    }

    public function test_not_authenticate()
    {
        $response = $this->get(route('articles.edit', ['id' => $this->article->id]));
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_not_found()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('articles.edit', ['id' => 1000000000]));
        $response->assertStatus(404)
            ->assertSeeText('Not Found');
    }

    public function test_not_create_user()
    {
        $another_user = User::factory()->create();
        $this->actingAs($another_user);
        $response = $this->get(route('articles.edit', ['id' => $this->article->id]));
        $response->assertStatus(403)
            ->assertSeeText('Forbidden');
    }

    public function test_correct_edit_page()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('articles.edit', ['id' => $this->article->id]));
        $response->assertStatus(200)
            ->assertSee('Article Edit')
            ->assertSee('article title')
            ->assertSee('article body');
    }

    public function tearDown(): void
    {
        (new Article())->newQuery()->delete();
        (new User())->newQuery()->delete();
        parent::tearDown();
    }
}
