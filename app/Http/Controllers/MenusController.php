<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Activity;
use Carbon\Carbon;

class MenusController extends Controller
{
  public function show($id)
  {
    $menu = Menu::where('id', '=', $id)->first();
    if (!$menu) {
      return redirect('/home')->with('status', '練習メニューが見つかりません');
    }
    // $url = url()->previous();
    return view('menus.edit')
            ->with('menu', $menu);
            // ->with('url', $url);
  }

  public function update(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30',
      'menu' => 'required'
    ]);

    $menu = Menu::where('id', '=', $request->mid)->first();
    if (!$menu) {
      return redirect('/home')->with('status', '練習メニューが見つかりません');
    }
    $menu->name = $request->name;
    $menu->menu = $request->menu;
    $menu->save();

    return redirect($request->url)->with('status', '練習メニューを更新しました');
  }

  public function create(Request $request)
  {
    $activity = Activity::where('id', '=', $request->aid)->first();
    if (!$activity) {
      return redirect('/home')->with('status', 'アクティビティが見つかりません');
    }
    return view('menus.create')
            ->with('activity', $activity);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:30',
      'menu' => 'required'
    ]);
    $menu = new Menu();
    $menu->activity_id = $request->aid;
    $menu->name = $request->name;
    $menu->menu = $request->menu;
    $menu->save();

    return redirect($request->url)->with('status', '練習メニューを登録しました');
  }

  /*
  *  指定したメニューの案内メール本文を生成する
  *
  */
  public function mail($mid)
  {
    $menu = Menu::where('id', '=', $mid)->first();
    if (!$menu) {
      return redirect('/home')->with('status', '練習メニューが見つかりません');
    }
    // 日付の取得
    $act_at = date('Y-m-d', strtotime($menu->activity->act_at));
    $md = date('m月d日', strtotime($menu->activity->act_at));
    $m = date('m', strtotime($menu->activity->act_at));
    $today = Carbon::today()->toDateString();
    $tomorrow = Carbon::tomorrow()->toDateString();

    if ($m == 12) {
      $m_next = 1;
    } else {
      $m_next = $m + 1;
    }

    //------ 文面の生成 ------------------------------
    // 書き出し ---------------------------
    $mail = $menu->name . "です．\n";
    if ($act_at == $today) {
      $mail .=   "本日の練習予定をお知らせします．";
    } elseif ($act_at == $tomorrow) {
      $mail .=   "あすの練習予定をお知らせします．";
    } else {
      $mail .=   $md . "の練習予定をお知らせします．";
    }

    // 日時と場所 ---------------------------
    $mail .= "\n\n";
    $mail .= $md . parent::get_youbi($menu->activity->act_at) . " " . $menu->activity->time->jikan . "\n";
    $mail .= $menu->activity->place->place;
    if ($menu->activity->note) {
      $mail .= "\n" . $menu->activity->note;
    }
    $mail .= "\n\n";

    // メニュー ---------------------------
    $mail .= $menu->menu . "\n\n";

    // 出欠登録 ---------------------------
    $mail .= "★出欠登録（暗号化通信に対応しました）★\n";
    $mail .= "※ " . $m . "月，" . $m_next . "月の登録をお願いします．\n";
    $mail .= \Config::get('const.URL');
    $mail .= "\nLogin ID : " . \Config::get('const.UID');
    $mail .= "\nPassword : " . \Config::get('const.UPW');
    $mail .= "\n\n";

    // 今後の練習予定 ---------------------------
    $mail .= "★今後の練習予定★\n";
    // 指定日以降の練習予定だけを取得
    $activities = Activity::where('act_at', '>', $menu->activity->act_at)
                      ->orderBy('act_at')->get();
    // 月ごとにまとめる
    $m_prev = 0;
    foreach ($activities as $activity) {
      $y = date('Y', strtotime($activity->act_at));
      $m = date('m', strtotime($activity->act_at));
      $d = date('d', strtotime($activity->act_at));
      // 次が変われば行を追加
      if ($m_prev != $m) {
        $mail .= "【" . $m . "月】\n";
      }
      $act = $m . "月" . $d . "日" . parent::get_youbi($activity->act_at);
      $act = $act . " " . $activity->time->jikan;
      $mail .= $act . "\n"; // 追加（改行）
      $act = "　" . $activity->place->place . " " . $activity->note;
      $mail .= $act . "\n"; // 追加（改行）
      $m_prev = $m;

    }

    // dd($menu->activity->act_at, $activities, $mail);
    return view('menus.mail')
              ->with('menu', $menu)
              ->with('mail', $mail);
  }
}
