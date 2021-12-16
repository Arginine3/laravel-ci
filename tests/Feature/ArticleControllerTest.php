<?php

namespace Tests\Feature;

use App\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    //データベースをリセット
    use RefreshDatabase;

    public function testIndex()
    {
        //$thisは ArticleControllerTestを指す
        $response = $this->get(route('articles.index'));

        //TestResponseクラス(get()のこと)は、assertStatusメソッドが使えます。
        $response->assertStatus(400)
            ->assertViewIs('articles.index');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        //テストに必要なモデルのインスタンスを作成
        $user = factory(User::class)->create();

        //ログインした状態を作り出す(ログイン済みの状態でアクセスしたことになる)
        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
