<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UsersHomeTest extends TestCase
{
  /**
   * A basic test example.
   *
   * @return void
   */
  public function testExample()
  {
    $response = $this->get('/');
    $response->assertStatus(200);
  }

  public function testTopPageError()
  {
      // エラーになるので，それを確認する．
      $response = $this->get('/hoge');
      $response->assertStatus(404);
  }

  public function testLoginPage()
  {
    // ログインページ
    $response = $this->get('/login')
                      ->assertSee('Login ID')
                      ->assertSee('Password');
    $response->assertStatus(200);
  }

  public function testLoginAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/')
                      ->assertSee('予定')
                      ->assertSee('KatWO メンバー');

    $response = $this->actingAs($user)
                      ->get('/home/2018/10')
                      ->assertSee('登録')
                      ->assertSee('常磐');


    $response = $this->actingAs($user)
                     ->get('/home/2018/12')
                     ->assertSee('登録')
                     ->assertSee('常磐');

    $response = $this->actingAs($user)
                      ->get('/home/2019/01')
                      ->assertSee('登録')
                      ->assertSee('まだ');


    $response = $this->actingAs($user)
                      ->get('/home/2018/09/create')
                      ->assertSee('パート')
                      ->assertSee('必須')
                      ->assertSee('ニックネーム')
                      ->assertSee('コメント')
                      ->assertSee('登録')
                      ->assertSee('戻る');

    $response = $this->actingAs($user)
                      ->get('/home/2018/05/create')
                      ->assertRedirect('/home/2018/05');
  }

  public function testCreateAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'part' => "8",
                        'name' => "test_json",
                        'act4' => "3",
                        'comment4' => "JSON テストコメント",
                        'act5' => "3",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "これもコメント JSON",
                        'act7' => "3",
                        'comment7' => "JSON JSON"
                      ]);

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'part' => "8",
                        'name' => "たろー",  // 名前が重複
                        'act4' => "3",
                        'comment4' => "JSON テストコメント",
                        'act5' => "2",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "これもコメント JSON",
                        'act7' => "3",
                        'comment7' => "JSON JSON"
                      ]);

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'part' => "",  // パート未選択
                        'name' => "ながいなまえ",
                        'act4' => "3",
                        'comment4' => "JSON テストコメント",
                        'act5' => "3",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "これもコメント JSON",
                        'act7' => "3",
                        'comment7' => "JSON JSON"
                      ]);

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'part' => "2",
                        'name' => "ながいなまえながいなまえながいなまえながいなまえながいなまえながいなまえながいなまえながいなまえながいなまえながいなまえ",  // 名前長い
                        'act4' => "3",
                        'comment4' => "JSON テストコメント",
                        'act5' => "3",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "これもコメント JSON",
                        'act7' => "3",
                        'comment7' => "JSON JSON"
                      ]);

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'part' => "2",
                        'name' => "長いコメント",
                        'act4' => "3",
                        'comment4' => "コメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよコメントは最大140文字ですよ",
                        'act5' => "1",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "これもコメント JSON",
                        'act7' => "3",
                        'comment7' => "JSON JSON"
                      ]);

  }

  public function testShowNewAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/2018/09')
                      ->assertSee('新規')
                      // ->assertSee('更新')
                      ->assertSee('KatWO メンバー');
  }

  public function testEditAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/2018/09/12/edit')
                      ->assertSee('パート')
                      ->assertSee('予定を変更します')
                      ->assertSee('コメント')
                      ->assertSee('予定を変更')
                      ->assertSee('戻る');

    $response = $this->actingAs($user)
                      ->get('/home/2018/05/12/edit')
                      ->assertRedirect('/home/2018/05');

    $response = $this->actingAs($user)
                      ->get('/home/2018/08/99/edit')
                      ->assertRedirect('/home/2018/08');
  }


  public function testUpdateAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->json('PATCH', '/home', [
                        'year' => "2018",
                        'month' => "09",
                        'n_act' => "4",
                        'aid' => "12",
                        'part' => "8",
                        'name' => "test_json",
                        'atten9' => "3",
                        'comment4' => "JSON テストコメント 更新",
                        'atten10' => "0",
                        'comment5' => "",
                        'atten11' => "1",
                        'comment6' => "これもコメント JSON",
                        'atten12' => "3",
                        'comment7' => "JSON JSON"
                      ]);
  }

  public function testShowUpdateAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/2018/09')
                      // ->assertSee('新規')
                      ->assertSee('更新')
                      ->assertSee('KatWO メンバー');
  }
}
