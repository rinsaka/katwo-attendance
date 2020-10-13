<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UsersHomeTest extends TestCase
{

  public function __construct()
  {
    // 日付の取得
    $year = (int)date('Y');
    $month = (int)date('m');
    // var_dump($this->year);

    // 3ヶ月前から8ヶ月後までの年と月を配列に格納
    $this->ymlist = array();
    for ($i = -3; $i <= 8; $i++) {
      $this->ymlist[$i] = $this->shift_month($year, $month, $i);
    }
  }


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
                      ->get('/home/'. $this->ymlist[2][0] . '/' . $this->ymlist[2][1])
                      ->assertSee('登録')
                      ->assertSee('常磐');

    // dd('/home/'. $this->ymlist[4][0] . '/' . $this->ymlist[4][1]);
    $response = $this->actingAs($user)
                     ->get('/home/'. $this->ymlist[4][0] . '/' . $this->ymlist[4][1])
                     ->assertSee('登録')
                     ->assertSee('瀬楽');

    $response = $this->actingAs($user)
                      // ->get('/home/2019/01')
                      ->get('/home/'. $this->ymlist[5][0] . '/' . $this->ymlist[5][1])
                      ->assertSee('登録')
                      ->assertSee('まだ');


    $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[1][0] . '/' . $this->ymlist[1][1] .'/create')
                      ->assertSee('パート')
                      ->assertSee('必須')
                      ->assertSee('ニックネーム')
                      ->assertSee('コメント')
                      ->assertSee('登録')
                      ->assertSee('戻る');

    $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1] .'/create')
                      ->assertRedirect('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1]);

    // 1月，12月の切り替えチェック
    $response = $this->actingAs($user)
                     ->get('/home/'. $this->ymlist[0][0] . '/1')
                     ->assertSee('12月')
                     ->assertSee('2月');

     // 1月，12月の切り替えチェック
     $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[0][0] . '/12')
                      ->assertSee('11月')
                      ->assertSee('1月');

      // 不正なURL
      $response = $this->actingAs($user)
                       ->get('/home/'. $this->ymlist[0][0] . '/13')
                       ->assertRedirect('/home/');
  }

  public function testCreateAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                      ->get('/home/'. $this->ymlist[1][0] . '/' . $this->ymlist[1][1])
                      ->assertSee('新規')
                      // ->assertSee('更新')
                      ->assertSee('KatWO メンバー');
  }

  public function testEditAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[1][0] . '/' . $this->ymlist[1][1] . '/12/edit')
                      ->assertSee('パート')
                      ->assertSee('予定を変更します')
                      ->assertSee('コメント')
                      ->assertSee('予定を変更')
                      ->assertSee('戻る');

    // dd('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1] . '/12/edit');
    $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1] . '/12/edit')
                      ->assertRedirect('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1]);
    //
    $response = $this->actingAs($user)
                      ->get('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1] . '/9999/edit')
                      ->assertRedirect('/home/'. $this->ymlist[-3][0] . '/' . $this->ymlist[-3][1]);
    //
    $response = $this->actingAs($user)
                      // ->get('/home/2018/08/99/edit')
                      ->get('/home/'. $this->ymlist[0][0] . '/' . $this->ymlist[0][1] . '/99/edit')
                      ->assertRedirect('/home/'. $this->ymlist[0][0] . '/' . $this->ymlist[0][1]);
  }


  public function testUpdateAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->json('PATCH', '/home', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
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
                      ->get('/home/'. $this->ymlist[1][0] . '/' . $this->ymlist[1][1])
                      // ->assertSee('新規')
                      ->assertSee('更新')
                      ->assertSee('KatWO メンバー');
  }


  // 追加して削除する
  public function testCreateAndDelete()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
                        'n_act' => "4",
                        'part' => "1",
                        'name' => "サブロー",
                        'act4' => "3",
                        'comment4' => "あとで削除します",
                        'act5' => "3",
                        'comment5' => "",
                        'act6' => "1",
                        'comment6' => "削除してね",
                        'act7' => "3",
                        'comment7' => "これ失敗"
                      ]);

    $response = $this->actingAs($user)
                      ->json('POST', '/home/confirm_delete', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
                        'name' => "サブロー",
                        'aid' => "13",
                        'attens' => array(13, 14, 15, 16),
                      ]);

    $response = $this->actingAs($user)
                      ->json('DELETE', '/home', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
                        'name' => "サブロー",
                        'aid' => "13",
                        'attens' => array(13, 14, 15, 16),
                        'delete_token' => "katwo",
                        'confirmation' => "hoge"  // 文字列が異なるので削除エラー
                      ]);

    $response = $this->actingAs($user)
                      ->json('DELETE', '/home', [
                        'year' => $this->ymlist[1][0],
                        'month' => $this->ymlist[1][1],
                        'name' => "サブロー",
                        'aid' => "13",
                        'attens' => array(13, 14, 15, 16),
                        'delete_token' => "katwo",
                        'confirmation' => "katwo"
                      ]);
  }



  /**
  *     月をずらす
  *
  *
  **/
  private function shift_month($year, $month, $shift = 0)
  {
    if ($shift == 0) {
      return array($year, $month);
    } elseif ($shift > 0) {  // 増やす
      for ($i = 1; $i <= $shift; $i++) {
        if ($month == 12) {
          $year++;
          $month = 1;
        } else {
          $month++;
        }
      }
      return array($year, $month);
    } else { // 減らす
      for ($i = -1; $i >= $shift; $i--) {
        if ($month == 1) {
          $year--;
          $month = 12;
        } else {
          $month--;
        }
      }
      return array($year, $month);
    }
  }

  public function testListAllActAsUser()
  {
    $user = User::where('id',1)->first();

    $response = $this->actingAs($user)
                      ->get('/home/list')
                      ->assertSee('すべての予定')
                      ->assertSee('KatWO メンバー');
  }

}
