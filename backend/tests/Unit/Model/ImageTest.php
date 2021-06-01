<?php

namespace Tests\Unit\Model;

use App\Models\Article;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    public function testFactoryable()
    {
        // 初期状態でデータ我からのことを確認
        $eloquent = app(Image::class);
        $this->assertEmpty($eloquent->get());

        // ファクトリーでデータが作成されたことを確認
        $article = $this->createArticle();
       
        Image::factory()->create([
            'article_id' => $article->id,
            'url' => 'test.test'
        ]);
        $this->assertNotEmpty($eloquent->get());
    }

    public function testBelongsToArticle()
    {
        $article = $this->createArticle();
       
        $image = Image::factory()->create([
            'article_id' => $article->id,
            'url' => 'test.test'
        ]);
        $image_id = $image->id;

        $this->assertNotEmpty($image->article);
        $this->assertNotEmpty(Image::find($image_id));

        // 記事が削除された場合、紐付いている画像も消える。
        $article->delete();
        $this->assertEmpty(Image::find($image_id));
    }

    protected function createArticle()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create([
            'user_id' => $user->id,
        ]);

        return $article;
    }
}
