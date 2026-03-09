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

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/activity/1')
                      ->assertSee('活動予定の表示と編集')
                      ->assertSee('日にち')
                      ->assertSee('活動予定を変更')
                      ->assertSee('管理者');
    //
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
    //
    // 活動形態の指定でエラー
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[18],
                        'time' => "",
                        'place' => "1",
                        'meeting' => "1",
                        'note' => ""
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
    //
    // 7ヶ月先の予定(3回目：選曲委員会)をさらに追加
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[19],
                        'time' => null,
                        'place' => "2",
                        'note' => "選曲委員会 10:00~12:00"
                      ]);
    //
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

  public function testPlaceCreateUpdateDeleteAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/create')
                      ->assertSee('活動施設名')
                      ->assertSee('新規登録')
                      ->assertSee('デフォルト')
                      ->assertSee('管理者');

    // 練習施設の追加
    $response = $this->actingAs($admin, 'admin')
            ->json('POST', '/admin/place', [
              'place' => "新しい練習施設A",
            ]);
    $response = $this->actingAs($admin, 'admin')
            ->json('POST', '/admin/place', [
              'place' => "新しい練習施設B",
              'default_place' => '1',
            ]);
    // 編集できない
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/place', [
              'pid' => '99a',
              'place' => "そんな施設は存在しない",
            ]);
    // 編集
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/place', [
              'pid' => '8',
              'place' => "新しい練習施設B更新",
            ]);
    // 編集
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/place', [
              'pid' => '7',
              'place' => "新しい練習施設A更新デフォルト",
              'default_place' => '1',
            ]);
    // 常盤Bは削除できない
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/2/delete')
                      ->assertRedirect('/admin/place/2');

    // 施設がない
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/99a/delete')
                      ->assertRedirect('/admin/home');
    // B を削除（確認画面）
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/place/8/delete')
                      ->assertSee('活動施設情報を削除')
                      ->assertSee('この操作は元に戻せません')
                      ->assertSee('登録済み活動回数');

    // B を削除
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/place/8', []);
    // 削除できない
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/place/99a', [])
            ->assertRedirect('/admin/home');
    // A を削除し，デフォルトが移行
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/place/7', [])
            ->assertRedirect('/admin/place');

  }



  public function testTimeAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time')
                      ->assertSee('13:00 - 17:00')
                      ->assertSee('活動時間一覧')
                      ->assertSee('デフォルト')
                      ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/1')
                      ->assertSee('13:00 - 17:00')
                      ->assertSee('活動時間の編集')
                      ->assertSee('デフォルト活動時間')
                      ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/99a')
                      ->assertRedirect('/admin/home/');
  }


  public function testTimeCreateUpdateDeleteAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    // dd($admin);
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/create')
                      ->assertSee('活動時間')
                      ->assertSee('新規登録')
                      ->assertSee('デフォルト')
                      ->assertSee('管理者');

    // 活動時間の追加
    $response = $this->actingAs($admin, 'admin')
            ->json('POST', '/admin/time', [
              'jikan' => "新しい練習時間A",
            ]);
    $response = $this->actingAs($admin, 'admin')
            ->json('POST', '/admin/time', [
              'jikan' => "新しい練習時間B",
              'default_jikan' => '1',
            ]);
    // 編集できない
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/time', [
              'tid' => '99a',
              'jikan' => "そんな時間は存在しない",
            ]);
    // 編集
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/time', [
              'tid' => '6',
              'jikan' => "新しい練習時間B更新",
            ]);
    // 編集
    $response = $this->actingAs($admin, 'admin')
            ->json('PATCH', '/admin/time', [
              'tid' => '5',
              'jikan' => "新しい練習時間A更新デフォルト",
              'default_jikan' => '1',
            ]);
    // 時間18:00-22:00は削除できない
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/3/delete')
                      ->assertRedirect('/admin/time/3');

    // 時間がない
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/99a/delete')
                      ->assertRedirect('/admin/home');
    // B を削除（確認画面）
    $response = $this->actingAs($admin, 'admin')
                      ->get('/admin/time/6/delete')
                      ->assertSee('活動時間情報を削除')
                      ->assertSee('この操作は元に戻せません')
                      ->assertSee('登録済み活動回数');

    // B を削除
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/time/6', []);
    // 削除できない
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/time/99a', [])
            ->assertRedirect('/admin/home');
    // A を削除し，デフォルトが移行
    $response = $this->actingAs($admin, 'admin')
            ->json('DELETE', '/admin/time/5', [])
            ->assertRedirect('/admin/time');

  }

  public function testAddMeetingActivitiesAsAdmin()
  {
    $admin = Admin::where('id',1)->first();
    $acts = $this->mk_activities();
    // dd($acts[0]);
    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/activity', [
                        'act_at' => $acts[0],
                        'time' => null,
                        'place' => "1",
                        'meeting' => "1",
                        'note' => "選曲委員会 10:00~12:00"
                      ]);
    //
    // 一部団員対象：活動内容を空で更新エラー
    $response = $this->actingAs($admin, 'admin')
                      ->json('PATCH', '/admin/activity', [
                        'aid' => "22",
                        'act_at' => $acts[0],
                        'time' => null,
                        'place' => "1",
                        'meeting' => "1",
                        'note' => ""
                      ]);
    // 参加登録
    $user = User::where('id',1)->first();
    // dd($user, $this->ymlist, $this->ymlist[0][0], $this->ymlist[0][1]);
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "1",
                        'name' => "あい うえお",
                        'act22' => "3",
                        'comment22' => "あいうえおあいうえおあいうえおあいうえお",
                        'act1' => "1",
                        'comment1' => "おあいうえおおあいうえおおあ",
                        'act2' => "3",
                        'comment2' => "",
                        'act3' => "0",
                        'comment3' => "これもコメント JSON"
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "3",
                        'name' => "かき くけこ",
                        'act22' => "1",
                        'comment22' => "",
                        'act1' => "0",
                        'comment1' => "",
                        'act2' => "0",
                        'comment2' => "",
                        'act3' => "0",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "2",
                        'name' => "さし すせそ",
                        'act22' => "-1",
                        'comment22' => "",
                        'act1' => "0",
                        'comment1' => "",
                        'act2' => "1",
                        'comment2' => "",
                        'act3' => "1",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "2",
                        'name' => "たち つてと",
                        'act22' => "-1",
                        'comment22' => "",
                        'act1' => "0",
                        'comment1' => "",
                        'act2' => "0",
                        'comment2' => "",
                        'act3' => "0",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "3",
                        'name' => "なにぬ ねの",
                        'act22' => "1",
                        'comment22' => "",
                        'act1' => "1",
                        'comment1' => "",
                        'act2' => "1",
                        'comment2' => "",
                        'act3' => "1",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "4",
                        'name' => "はひ ふへほ",
                        'act22' => "3",
                        'comment22' => "はひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへお",
                        'act1' => "3",
                        'comment1' => "はひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへお",
                        'act2' => "3",
                        'comment2' => "はひふへお",
                        'act3' => "3",
                        'comment3' => "はひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへおはひふへお"
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "5",
                        'name' => "まみ むめも",
                        'act22' => "-1",
                        'comment22' => "",
                        'act1' => "3",
                        'comment1' => "",
                        'act2' => "3",
                        'comment2' => "",
                        'act3' => "3",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "7",
                        'name' => "やいゆ えよ",
                        'act22' => "3",
                        'comment22' => "",
                        'act1' => "3",
                        'comment1' => "",
                        'act2' => "3",
                        'comment2' => "",
                        'act3' => "3",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user, 'user')
                      ->json('POST', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'part' => "8",
                        'name' => "わおん",
                        'act22' => "3",
                        'comment22' => "",
                        'act1' => "1",
                        'comment1' => "",
                        'act2' => "3",
                        'comment2' => "",
                        'act3' => "0",
                        'comment3' => ""
                      ]);
    //
    $response = $this->actingAs($user)
                      ->json('PATCH', '/home', [
                        'year' => $this->ymlist[0][0],
                        'month' => $this->ymlist[0][1],
                        'n_act' => "4",
                        'aid' => "15",
                        'part' => "1",
                        'name' => "あい うえお",
                        'atten15' => "-1",
                        'comment15' => "メンバー外でしたあいうえおあいうえおあいうえおあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえお",
                        'atten12' => "0",
                        'comment12' => "未定に変更おあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえおおあいうえお あい",
                        'atten13' => "3",
                        'comment13' => "",
                        'atten14' => "0",
                        'comment14' => "これもコメント JSON add"
                      ]);
    //




    // dd($admin);
    // $response = $this->actingAs($admin, 'admin')
    //                   ->get('/admin/time/create')
    //                   ->assertSee('活動時間')
    //                   ->assertSee('新規登録')
    //                   ->assertSee('デフォルト')
    //                   ->assertSee('管理者');
  }

  public function testAdminMainInfoController()
  {
    $admin = Admin::where('id',1)->first();

    $response = $this->actingAs($admin, 'admin')
                  ->get('/admin/mailinfo')
                  ->assertSee('フッタ')
                  ->assertSee('編集')
                  ->assertSee('更新')
                  ->assertSee('管理者');

    $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/mailinfo', [
                        'id' => "1",
                        'key' => "signiture",
                        'mailinfo' => "ぱぴぷぺぽ",
                      ]);
    //

    // 不正なパラメータ
     $response = $this->actingAs($admin, 'admin')
                      ->json('POST', '/admin/mailinfo', [
                        'id' => "99a",
                        'key' => "signiture",
                        'mailinfo' => "ぱぴぷぺぽ",
                      ]);
    //


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
