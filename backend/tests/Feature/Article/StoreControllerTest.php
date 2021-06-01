<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreControllerTest extends TestCase
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

    public function test_store_not_login()
    {
        // ログインしていない場合
        $response = $this->post(route('articles.store'));
        $response->assertStatus(302)
            ->assertRedirect('/login');;

        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('articles.store'));
        $response->assertRedirect('/');
    }

    /**
     *  @dataProvider article_invalid_data
     */
    public function test_store_invalid_data($params)
    {
        // 空っぽであることを確認
        $eloquent = app(Article::class);
        $this->assertCount(0, $eloquent->get());

        // ユーザーログイン
        $user = User::factory()->create();
        $this->actingAs($user);


        $response = $this->post(route('articles.store'), $params);
        $response->assertStatus(302);

        $this->assertCount(0, $eloquent->get());
    }


    /**
     *  @dataProvider article_valid_data
     */
    public function test_store_valid_data($params)
    {
        // 空っぽであることを確認
        $eloquent = app(Article::class);
        $this->assertCount(0, $eloquent->get());

        // ユーザーログイン
        $user = User::factory()->create();
        $this->actingAs($user);


        $response = $this->post(route('articles.store'), $params);
        $response->assertStatus(302);
        $this->assertCount(1, $eloquent->get());
    }

    public function article_valid_data()
    {
        return [
            'valid data' => [
                'request' => [
                    'title' => 'valid title',
                    'body' => 'valid body',
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
                    'body' => 'invalid body'
                ]
            ],
            'body invalid' => [
                'request' => [
                    'title' => 'invalid title',
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
