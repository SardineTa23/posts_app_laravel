<?php

namespace Tests\Unit\Model;

use App\Models\Article;
use App\Models\ArticleTagRelationship;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testFactoryable()
    {
        // 初期状態でデータが空のことを確認
        $eloquent = app(Article::class);
        $this->assertEmpty($eloquent->get());
        $user = User::factory()->create();
        // ファクトリーでデータが作成されたことを確認
        Article::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($eloquent->get());
    }

    // articleはユーザーに紐づくことを確認
    public function testBelongsToUser()
    {
        $user = User::factory()->create();
        $aritcle = Article::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->assertNotEmpty($aritcle->user);
    }

    // articleがimageをhasmanyしていることを確認
    public function testHasmanyImages()
    {
        $count = 3;
        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
        ]);
        Image::factory()->count($count)->create([
            'article_id' => $article->id,
            'url' => 'test.test'
        ]);

        $this->assertEquals($count, count($article->refresh()->images));
    }

    public function testHasmanyTags()
    {
        $count = 5;

        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
        ]);
        $tags = Tag::factory()->count($count)->create();

        foreach ($tags as $tag) {
            ArticleTagRelationship::factory()->create([
                'tag_id' => $tag->id,
                'article_id' => $article->id
            ]);
        }
        $this->assertEquals($count, count($article->refresh()->tags));
    }
}
