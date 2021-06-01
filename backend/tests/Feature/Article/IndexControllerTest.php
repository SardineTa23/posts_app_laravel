<?php

namespace Tests\Feature\Article;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $password = 'password';

    public function test_Index_page()
    {
        $this->sign_in();
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Article Index');
    }

    protected function sign_in()
    {
        $this->user = User::factory()->create([
            'password' => bcrypt($this->password)
        ]);

        // 認証されないことを確認
        $this->assertFalse(Auth::check());

        // ログインを実行
        $response = $this->post('login', [
            'email'    => $this->user->email,
            //先ほど設定したパスワードを入力
            'password' => $this->password
        ]);

        // 認証されていることを確認
        $this->assertAuthenticatedAs($this->user);
        $response->assertRedirect('/');
    }
}
