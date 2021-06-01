<?php

namespace Tests\Unit\Model;

use App\Models\Article;
use App\Models\ArticleTagRelationship;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function testFactoryable()
    {
        // 初期状態でデータが空のことを確認
        $eloquent = app(Tag::class);
        $this->assertEmpty($eloquent->get());

        // ファクトリーでデータが作成されたことを確認
        Tag::factory()->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testHasmanyArticle()
    {
        $count = 5;

        $user = User::factory()->create();
        $articles = Article::factory()->count($count)->create([
            'user_id' => $user->id,
        ]);
        $tag = Tag::factory()->create();

        foreach ($articles as $article) {
            ArticleTagRelationship::factory()->create([
                'tag_id' => $tag->id,
                'article_id' => $article->id
            ]);
        }
        $this->assertEquals($count, count($tag->refresh()->articles));
    }
}
