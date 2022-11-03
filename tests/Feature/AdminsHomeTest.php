<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Admin;
use App\User;


class AdminsHomeTest extends TestCase
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
  // public function testExample()
  // {
  //     $this->assertTrue(true);
  // }

  public function testAdminLoginPage()
  {
    // ログインページ
    $response = $this->get('/admin/login')
                      ->assertSee('Login ID')
                      ->assertSee('Password');
    $response->assertStatus(200);
  }

  public function testLoginAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/home')
                      ->assertSee('土')
                      ->assertSee('役員')
                      ->assertSee('アリーナ')
                      ->assertSee('管理者');

    // $response = $this->actingAs($admin, 'admin')
    //                   ->get('/admin/activity/16')
    //                   ->assertSee('日にち')
    //                   ->assertSee('時間')
    //                   ->assertSee('場所')
    //                   ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/activity/99');

  }

  public function testEditAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    $acts = $this->mk_activities();
    list($year, $month, $day) = explode('-', $acts[15]);
    $day = sprintf("%d",(int)$day + 1);
    $new_day = "$year-$month-$day"; // 1日進める

    $response = $this->actingAs($admin, 'admin')
                      ->json('PATCH', '/admin/activity', [
                        'act_at' => $new_day,
                        'time' => "1",
                        'place' => "1",
                        'note' => "土曜日から日曜日に変更しました",
                      ]);

    $response = $this->actingAs($admin, 'admin')
                      ->json('PATCH', '/admin/activity', [
                        'aid' => "16",
                        'act_at' => $new_day,
                        'time' => "0",
                        'place' => "0",
                        'note' => "時間と場所を一旦削除します",
                      ]);

    $response = $this->actingAs($admin, 'admin')
                      ->json('PATCH', '/admin/activity', [
                        'aid' => "16",
                        'act_at' => $new_day,
                        'time' => "1",
                        'place' => "1",
                        'note' => "土曜日から日曜日に変更しました",
                      ]);

  }

  public function testCreateAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/activity/create')
                      ->assertSee('日にち')
                      ->assertSee('時間')
                      ->assertSee('場所')
                      ->assertSee('登録');
    $acts = $this->mk_activities();

    // 4ヶ月先の4回目の練習を追加する
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[16],
                        'time' => "4",
                        'place' => "6",
                        'note' => "練習日程を追加しました"
                      ]);

    // dd($acts);
    // 7ヶ月先の予定(2回)を順次追加 ー＞まず1回め
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[18],
                        'time' => "0",
                        'place' => "0",
                        'note' => "練習日程を追加しました"
                      ]);
  }

  public function testEditAsUser()
  {
    // ユーザで出席登録
    $acts = $this->mk_activities();
    $user = User::where('id',1)->first();
    list($year,$month,$day) = explode('-', $acts[18]);
    $response = $this->actingAs($user)
                      ->json('POST', '/home', [
                        'year' => $year,
                        'month' => $month,
                        'n_act' => "1",
                        'part' => "9",
                        'name' => "天然記念物",
                        'act19' => "3",
                        'comment19' => "参加します．このあと，スケジュールが追加されます"
                      ]);
  }

  public function testCreateAsAdmin2()
  {
    $acts = $this->mk_activities();
    $admin = Admin::where('id',1)->first();

    // 7ヶ月先の予定(2回目)を追加
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[19],
                        'time' => "1",
                        'place' => "1",
                        'note' => "さらに追加された日程です"
                      ]);
  }

  public function testDeleteAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    $response = $this->actingAs($admin, 'admin')
                      ->json('DELETE', '/admin/activity/19', [
                        'confirmation' => "hoge",
                      ]);
    $response = $this->actingAs($admin, 'admin')
                      ->json('DELETE', '/admin/activity/99', [
                        'confirmation' => "yakuin",
                      ]);

    $response = $this->actingAs($admin, 'admin')
                      ->json('DELETE', '/admin/activity/19', [
                        'confirmation' => "yakuin",
                      ]);
  }

  public function testPlaceAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place')
                      ->assertSee('瀬楽スタジオ')
                      ->assertSee('活動施設一覧')
                      ->assertSee('アリーナ')
                      ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/6')
                      ->assertSee('瀬楽スタジオ')
                      ->assertSee('活動施設の編集')
                      ->assertSee('デフォルト活動施設')
                      ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/99a')
                      ->assertRedirect('/admin/home/');
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

  /**
  *    活動の一覧を作成する
  *       今月 3回
  *       翌月 4回（4回目運営会議）
  *       翌々月 3回（3回目総会）
  *       3ヶ月先 3回
  *       4ヶ月先 4回    （テストで1つ追加するのでシーダの内容と異なる）
  *       6ヶ月先 1回（本番）
  **/
  private function mk_activities()
  {
    $act_list = array(     // 月ごとの練習回数と曜日を指定
      ['count'=>3, 'w'=>6],
      ['count'=>4, 'w'=>6],
      ['count'=>3, 'w'=>6],
      ['count'=>3, 'w'=>6],
      ['count'=>4, 'w'=>6],
      ['count'=>0, 'w'=>6],
      ['count'=>0, 'w'=>6],
      ['count'=>3, 'w'=>6],
      ['count'=>1, 'w'=>0],
    );
    $year = date('Y');
    $month = date('m');
    $activities = array();
    $iter = 0;
    foreach($act_list as $act) {
      $m = $month + $iter;
      if ($m == 13) {
        $year = $year + 1;
        $m = $m -12;
      } elseif ($m > 13) {
        $m = $m - 12;
      }
      $tmp_acts = $this->get_activities($year, $m, $act['count'], $act['w']);
      if ($tmp_acts) {
        foreach($tmp_acts as $tmp_act) {
          $activities[] = $tmp_act;
        }
      }

      $iter++;
    }
    return $activities;
  }

  /**
  *    年と月を指定し，$count 回数だけ $w 曜日の日にちを返す．
  *
  *       $w : 0=>日，1=>月, ... 6=>土
  **/
  private function get_activities($year, $month, $count = 1, $w = 6)
  {
    if($count == 0) {
      return false;
    }
    $d = new \DateTime();
    $d->setDate($year, $month, 1);
    $t = $d->format('t'); // 月末の日にちを取得
    $zm = sprintf('%02d', $month);

    $n_activities = 0;
    $activities = array();
    for ($i = 1; $i <= $t; $i++) {
      $zi = sprintf('%02d', $i);
      $date = date('w', strtotime($year.$zm.$zi));
      if ($date == $w) {
        $activities[] = $year.'-'.$zm.'-'.$zi;
        $n_activities++;
        if ($n_activities == $count) {
          break;
        }
      }
    }
    return $activities;
  }
}
