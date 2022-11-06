<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

use App\Activity;
use App\Time;
use App\Place;
use App\Attendance;
use App\Admin;
use App\User;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth:admin');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $activities = Activity::orderBy('act_at')->get();
    return view('admin.home')
            ->with('activities', $activities);
  }

  public function edit($aid)
  {
    $activity = Activity::where('id', '=', $aid)->first();
    if(!$activity) {
      return redirect('/admin/home/')->with('status', "そのような活動予定がありません");
    }

    $times = Time::orderBy('jikan')->get();
    $places = Place::orderBy('id')->get();
    // dd("edit", $aid, $activity);
    return view('admin.edit')
            ->with('activity', $activity)
            ->with('times', $times)
            ->with('places', $places);
  }

  public function update(Request $request)
  {
    $this->validate($request, [
      'act_at' => 'required|date',
      'note' => 'max:140'
    ]);

    $activity = Activity::where('id', '=', $request->aid)->first();
    if (!$activity) {
      return redirect('/admin/home/')->with('status', "そのような活動予定がありません");
    }
    // dd($request->aid, $request->act_at, $request->time, $request->place, $request, $activity);

    // dd($request->act_at, strtotime($request->act_at), date('Y-m-01', strtotime($request->act_at)) );

    $activity->act_at = date('Y-m-d', strtotime($request->act_at));
    if ($request->time == "0") {
      $activity->time_id = null;
    } else {
      $activity->time_id = $request->time;
    }
    if ($request->place == "0") {
      $activity->place_id = null;
    } else {
      $activity->place_id = $request->place;
    }
    $activity->note = $request->note;
    $activity->save();

    return redirect('/admin/home/')
        ->with('status', $activity->act_at . "の活動予定を修正しました");
  }

  public function create()
  {
    // dd("create");
    $times = Time::orderBy('jikan')->get();
    $places = Place::orderBy('place')->get();
    return view('admin.create')
            ->with('times', $times)
            ->with('places', $places);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'act_at' => 'required|date',
      'note' => 'max:140',
    ]);
    $act_at = date('Y-m-d', strtotime($request->act_at));

    $activity = new Activity();
    $activity->act_at = $act_at;
    if ($request->time == "0") {
      $activity->time_id = null;
    } else {
      $activity->time_id = $request->time;
    }
    if ($request->place == "0") {
      $activity->place_id = null;
    } else {
      $activity->place_id = $request->place;
    }
    $activity->note = $request->note;
    $activity->save();

    // すでに同じ月の別の予定に出欠が登録されていれば，その人を「未定」として追加する．
    // 同じ月の活動を取得する
    $thismonth_head = date('Y-m-01',strtotime($act_at));
    $thismonth_tail = date('Y-m-t',strtotime($act_at));

    $acts = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->where('id', '<>', $activity->id)
                            ->get();
    // dd($acts);
    foreach ($acts as $act) {
      $attendances = Attendance::where('activity_id', '=', $act->id)->get();

      foreach ($attendances as $attendance) {
        // 登録済みかどうか
        $atten_exist = Attendance::where('activity_id', '=', $activity->id)
                                    ->where('name', '=', $attendance->name)
                                    ->first();
        if (!$atten_exist) { // まだ登録されていない
          $new_atten = new Attendance();
          $new_atten->activity_id = $activity->id;
          $new_atten->part_id = $attendance->part_id;
          $new_atten->name = $attendance->name;
          $new_atten->attendance = 0;
          $new_atten->comment = '※活動予定の追加により，この情報が自動的に生成されました．';
          $new_atten->save();
        }

      }

    }

    return redirect('/admin/home/')
        ->with('status', $activity->act_at . "活動予定を新規登録しました");
  }

  public function destory(Request $request, $id)
  {
    if($request->confirmation != 'yakuin') {
      return redirect('/admin/activity/'.$id)->with('status', "確認用文字列を入力してください");
    }
    $activity = Activity::where('id', '=', $id)->first();
    if (!$activity) {
      return redirect('/admin/home')->with('status', "そのような活動予定がありません");
    }
    $activity->delete();  // cascade にしているので関連した attendances も消える

    return redirect('/admin/home')
            ->with('status', $activity->act_at . " の活動予定を削除しました");
  }

  public function passwd()
  {
    $admin = \Auth::user();
    return view('admin.passwd')
            ->with('id', $admin->id);
  }

  public function passwd_update(Request $request)
  {
    $admin = \Auth::user();
    // 現在のパスワードを確認
    if (!password_verify($request->current_password, $admin->password)) {
      return redirect('/admin/password')
          ->with('status', 'パスワードが違います');
    }
    // ここはありえないはず
    if ($request->id != $admin->id) {
      return redirect('/admin/password')
          ->with('status', 'IDが不正です');
    }
    // Validation（6文字以上あるか，2つが一致しているかなどのチェック）
    $this->validate($request, [
      'new_password' => 'required|string|min:6|confirmed'
    ]);

    // パスワードを保存
    $admin->password = bcrypt($request->new_password);
    $admin->save();
    return redirect('/admin/home')
            ->with('status', 'パスワードを変更しました');
  }

  /*
  *   ユーザ（団員）パスワードの変更画面
  */
  public function userpasswd()
  {
    $admin = \Auth::user();
    // dd($admin);
    return view('admin.userpasswd')
            ->with('id', $admin->id);
  }


  public function userpasswd_update(Request $request)
  {
    $admin = \Auth::user();
    // 現在のパスワードを確認
    if (!password_verify($request->password, $admin->password)) {
      return redirect('/admin/userpassword')
          ->with('status', 'パスワードが違います');
    }
    $this->validate($request, [
      'login_id' => 'required',
      'new_password' => 'required|string|min:6|confirmed'
    ]);
    $user = User::where('login_id', '=', $request->login_id)->first();
    if (!$user) {
      return redirect('/admin/userpassword')
          ->with('status', '団員のログインIDが違います');
    }
    // パスワードを保存
    $user->password = bcrypt($request->new_password);
    $user->save();
    return redirect('/admin/home')
            ->with('status', '団員 '. $user->login_id . ' のパスワードを変更しました');
  }

  /*
  *
  * 練習場所の一覧
  *
  */
  public function place()
  {
    $places = Place::orderBy('place')->get();
    // dd($places);
    return view('admin.place.index')
            ->with('places', $places);
  }

  public function place_edit($pid)
  {
    $place = Place::where('id', '=', $pid)->first();
    if(!$place) {
      return redirect('/admin/home/')->with('warning', "そのような活動施設がありません");
    }
    // dd($place);
    return view('admin.place.edit')
            ->with('place', $place);
  }

  public function place_update(Request $request)
  {
    $this->validate($request, [
      'place' => [
        'required',
        'max:100',
        Rule::unique('places')->ignore($request->pid),
      ],
    ]);
    $place = Place::where('id', '=', $request->pid)->first();
    if (!$place) {
      return redirect('/admin/home/')->with('warning', "そのような活動施設がありません");
    }
    $place->place = $request->place;
    if ($place->default_place == 0 && isset($request->default_place)) {
      // デフォルト活動場所が変更された
      $prev_default = Place::where('default_place', '=', 1)->first();
      if ($prev_default) {
        $prev_default->default_place = 0;
        $prev_default->save();
      }
      $place->default_place = 1;
    }

    $place->save();
    return redirect()->action('Admin\HomeController@place')
          ->with('status', "活動施設情報を更新しました");
  }

  public function place_create()
  {
    return view('admin.place.create');
  }

  public function place_store(Request $request)
  {
    $this->validate($request, [
      'place' => [
        'required',
        'max:100',
        Rule::unique('places'),
      ],
    ]);
    $place = new Place();
    $place->place = $request->place;
    if (isset($request->default_place)) {
      // デフォルト活動場所が変更された
      $prev_default = Place::where('default_place', '=', 1)->first();
      $prev_default->default_place = 0;
      $prev_default->save();
      $place->default_place = 1;
    } else {
      $place->default_place = 0;
    }
    $place->save();
    return redirect()->action('Admin\HomeController@place')
          ->with('status', "活動施設情報を登録しました");
  }

  public function place_delete($pid)
  {
    $place = Place::where('id', '=', $pid)->first();
    if(!$place) {
      return redirect('/admin/home/')->with('warning', "そのような活動施設がありません");
    }
    // その施設での登録済活動回数を取得する．
    // $cnt = 0;
    $cnt = Activity::where('place_id', '=', $pid)->count();
    if ($cnt > 0) {
      return redirect('/admin/place/'.$pid)->with('warning', "この施設での活動が" . $cnt .  "回登録されているので施設情報を削除できません．削除する前にこの施設での活動予定を削除してください．");
    }
    // dd($place);
    return view('admin.place.delete')
            ->with('place', $place)
            ->with('cnt', $cnt);
  }

  public function place_destroy($pid)
  {
    $place = Place::where('id', '=', $pid)->first();
    if(!$place) {
      return redirect('/admin/home/')->with('warning', "そのような活動施設がありません");
    }
    $place->delete();
    // 削除した後，default_place がなければ，どれかを default_placeにする
    // なお，データベースから削除しても $place 自体はまだ生きている
    if ($place->default_place == 1) {
      $default_place = Place::get()->first();
      if ($default_place) {
        $default_place->default_place = 1;
        $default_place->save();
        return redirect('/admin/place/')->with('status', "活動施設情報を削除し，デフォルト活動施設を変更しました");
      } else {
        // @codeCoverageIgnoreStart
        return redirect('/admin/place/')->with('status', "すべての活動施設情報が削除されました");
        // @codeCoverageIgnoreEnd
      }
    }
    return redirect('/admin/place/')->with('status', "活動施設情報を削除しました");
  }

  /*
  *
  * 練習時間の一覧
  *
  */
  public function time()
  {
    $times = Time::orderBy('jikan')->get();
    // dd($places);
    return view('admin.time.index')
            ->with('times', $times);
  }

  public function time_edit($tid)
  {
    $time = Time::where('id', '=', $tid)->first();
    if(!$time) {
      return redirect('/admin/home/')->with('warning', "そのような活動時間がありません");
    }
    // dd($time);
    return view('admin.time.edit')
            ->with('time', $time);
  }

  public function time_update(Request $request)
  {
    $this->validate($request, [
      'jikan' => [
        'required',
        'max:100',
        Rule::unique('times')->ignore($request->tid),
      ],
    ]);
    $time = Time::where('id', '=', $request->tid)->first();
    if (!$time) {
      return redirect('/admin/home/')->with('warning', "そのような活動時間がありません");
    }
    $time->jikan = $request->jikan;
    if ($time->default_jikan == 0 && isset($request->default_jikan)) {
      // デフォルト活動時間が変更された
      $prev_default = Time::where('default_jikan', '=', 1)->first();
      if ($prev_default) {
        $prev_default->default_jikan = 0;
        $prev_default->save();
      }
      $time->default_jikan = 1;
    }

    $time->save();
    return redirect()->action('Admin\HomeController@time')
          ->with('status', "活動時間情報を更新しました");
  }

  public function time_create()
  {
    return view('admin.time.create');
  }

  public function time_store(Request $request)
  {
    $this->validate($request, [
      'jikan' => [
        'required',
        'max:100',
        Rule::unique('times'),
      ],
    ]);
    $time = new Time();
    $time->jikan = $request->jikan;
    if (isset($request->default_jikan)) {
      // デフォルト活動時間が変更された
      $prev_default = Time::where('default_jikan', '=', 1)->first();
      $prev_default->default_jikan = 0;
      $prev_default->save();
      $time->default_jikan = 1;
    } else {
      $time->default_jikan = 0;
    }
    $time->save();
    return redirect()->action('Admin\HomeController@time')
          ->with('status', "活動時間情報を登録しました");
  }

  public function time_delete($tid)
  {
    $time = Time::where('id', '=', $tid)->first();
    if(!$time) {
      return redirect('/admin/home/')->with('warning', "そのような活動時間がありません");
    }
    // その時間での登録済活動回数を取得する．
    // $cnt = 0;
    $cnt = Activity::where('time_id', '=', $tid)->count();
    if ($cnt > 0) {
      return redirect('/admin/time/'.$tid)->with('warning', "この時間での活動が" . $cnt .  "回登録されているので時間情報を削除できません．削除する前にこの時間での活動予定を削除してください．");
    }
    // dd($time);
    return view('admin.time.delete')
            ->with('time', $time)
            ->with('cnt', $cnt);
  }

  public function time_destroy($tid)
  {
    $time = Time::where('id', '=', $tid)->first();
    if(!$time) {
      return redirect('/admin/home/')->with('warning', "そのような活動時間がありません");
    }
    $time->delete();
    // 削除した後，default_jikan がなければ，どれかを default_jikan にする
    // なお，データベースから削除しても $time 自体はまだ生きている
    if ($time->default_jikan == 1) {
      $default_jikan = Time::get()->first();
      if ($default_jikan) {
        $default_jikan->default_jikan = 1;
        $default_jikan->save();
        return redirect('/admin/time/')->with('status', "活動時間情報を削除し，デフォルト活動施設を変更しました");
      } else {
        // @codeCoverageIgnoreStart
        return redirect('/admin/time/')->with('status', "すべての活動時間情報が削除されました");
        // @codeCoverageIgnoreEnd
      }
    }
    return redirect('/admin/time/')->with('status', "活動時間情報を削除しました");
  }

}
