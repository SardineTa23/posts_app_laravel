<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_createdArticle()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'title' => 'title1',
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.show', ['id' => $article->id]));
        $response->assertStatus(200)
            ->assertSee('Article Show')
            ->assertSee('title1');
    }

    public function test_show_anotherArticle()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article1 = Article::factory()->create([
            'title' => 'article 1 title',
            'user_id' => $user->id
        ]);
        $article2 = Article::factory()->create([
            'title' => 'article 2 title',
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.show', ['id' => $article2->id]));
        $response->assertStatus(200)
            ->assertSee('Article Show')
            ->assertDontSee('article 1 title');
    }

    public function test_show_not_exit_article()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article1 = Article::factory()->create([
            'title' => 'title1',
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.show', ['id' => 10000000]));
        $response->assertStatus(404)
            ->assertSee('Not Found');
    }
}
