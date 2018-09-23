<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Activity;
use App\Time;
use App\Place;
use App\Attendance;

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
    $activity->time_id = $request->time;
    $activity->place_id = $request->place;
    $activity->note = $request->note;
    $activity->save();

    return redirect('/admin/home/')
        ->with('status', $activity->act_at . "の活動予定を修正しました");
  }

  public function create()
  {
    // dd("create");
    $times = Time::orderBy('jikan')->get();
    $places = Place::orderBy('id')->get();
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
    $activity->time_id = $request->time;
    $activity->place_id = $request->place;
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
}
