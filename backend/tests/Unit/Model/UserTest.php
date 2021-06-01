<?php

namespace Tests\Unit\Model;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testFactoryable()
    {
        // 初期状態でデータが空のことを確認
        $eloquent = app(User::class);
        $this->assertEmpty($eloquent->get());

        // ファクトリーでデータが作成されたことを確認
        User::factory()->create();
        $this->assertNotEmpty($eloquent->get());
    }

    public function testHasmanyArticle()
    {
        $count = 5;

        $user = User::factory()->create();
        Article::factory()->count($count)->create([
            'user_id' => $user->id,
        ]);
        $this->assertEquals($count, count($user->refresh()->articles));
    }
   
}
