<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateControllerTest extends TestCase
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
        $response = $this->patch(route('articles.update', ['id' => $this->article->id]));
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /**
     *  @dataProvider article_valid_data
     */
    public function test_not_found($params)
    {
        $this->actingAs($this->user);
        $response = $this->patch(route('articles.update', ['id' => 1000000000]), $params);
        $response->assertStatus(404)
            ->assertSeeText('Not Found');
    }

    /**
     *  @dataProvider article_valid_data
     */
    public function test_not_create_user($params)
    {
        $another_user = User::factory()->create();
        $this->actingAs($another_user);
        $response = $this->patch(route('articles.update', ['id' => $this->article->id]), $params);
        $response->assertStatus(403)
            ->assertSeeText('Forbidden');
    }

    /**
     *  @dataProvider article_valid_data
     */
    public function test_update_with_valid_data($params)
    {
        $this->actingAs($this->user);
        $response = $this->patch(route('articles.update', ['id' => $this->article->id]), $params);
        $response->assertStatus(302)
            ->assertRedirect(route('articles.show', ['id' => $this->article->id]));
        $this->assertDatabaseHas('articles', [
            'title' => 'update valid title',
            'body' => 'update valid body',
        ]);
    }

    /**
     *  @dataProvider article_invalid_data
     */
    public function test_update_with_invalid_data($params)
    {
        $this->actingAs($this->user);
        $response = $this->patch(route('articles.update', ['id' => $this->article->id]), $params);
        $response->assertStatus(302)
            ->assertRedirect('/');
        $this->assertDatabaseMissing('articles', [
            'title' => 'update invalid title',
        ]);
        $this->assertDatabaseMissing('articles', [
            'title' => 'update invalid body',
        ]);
    }

    public function article_valid_data()
    {
        return [
            'valid data' => [
                'request' => [
                    'title' => 'update valid title',
                    'body' => 'update valid body',
                ]
            ]
        ];
    }

    public function article_invalid_data()
    {
        return [
            'title invalid' => [
                'request' => [
                    'title' => null,
                    'body' => 'update invalid body'
                ]
            ],
            'body invalid' => [
                'request' => [
                    'title' => 'update invalid title',
                    'body' => null,
                ]
            ]
        ];
    }

    public function tearDown(): void
    {
        (new Article())->newQuery()->delete();
        (new User())->newQuery()->delete();
        parent::tearDown();
    }
}
