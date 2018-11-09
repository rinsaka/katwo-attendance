<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\Part;
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
      $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // 今月
    $thismonth_head = date('Y-m-01',time());
    $thismonth_tail = date('Y-m-t',time());
    $this_year = date('Y',time());
    $this_month = date('m',time());
    // 先月
    $prev_year = date('Y', strtotime('-1 month'));
    $prev_month = date('m', strtotime('-1 month'));
    // 来月
    $next_year = date('Y', strtotime('+1 month'));
    $next_month = date('m', strtotime('+1 month'));
    // dd($thismonth_head, $thismonth_tail, $prev_year, $prev_month, $next_year, $next_month);

    // Activity を取得
    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->orderBy('act_at')
                            ->get();
    // 各アクティビティについていろいろと取得する
    $activities = $this->get_Attendances_detail($activities);
    $iter = 0;
    foreach ($activities as $activity) {
      $activity->class_expansion_link = "expansion_link" . $iter;
      $activity->class_attendance = "attendance" . $iter;
      $iter++;
    }
    // dd($activities);

    return view('home')
            ->with('activities', $activities)
            ->with('prev_year', $prev_year)
            ->with('prev_month', $prev_month)
            ->with('next_year', $next_year)
            ->with('next_month', $next_month)
            ->with('this_year', $this_year)
            ->with('this_month', $this_month);
  }

  public function show($year, $month)
  {
    // URL の Validation
    if ($year > 2080 || $year < 2017 || $month < 1 || $month > 12) {
      return redirect('/home/')->with('status', "不正なURLです！");
    } // まだ home/2018/11.2/ のような場合も動いてしまう．この後 (int) でキャストしているので問題なし．

    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));
    $this_year = $year;
    $this_month = $month;

    $year = (int) $year;
    $month = (int) $month;
    if($month == 1) {
      $prev_year = $year - 1;
      $prev_month = 12;
      $next_year = $year;
      $next_month = 2;
    } elseif ($month == 12) {
      $prev_year = $year;
      $prev_month = 11;
      $next_year = $year + 1;
      $next_month = 1;
    } else {
      $prev_year = $year;
      $prev_month = $month - 1;
      $next_year = $year;
      $next_month = $month + 1;
    }
    // dd($thismonth_head, $thismonth_tail, $prev_year, $prev_month, $next_year, $next_month);
    // dd($year, $month, $thismonth_head, $thismonth_tail);

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->orderBy('act_at')
                            ->get();
    // 各アクティビティについていろいろと取得する
    $activities = $this->get_Attendances_detail($activities);
    $iter = 0;
    foreach ($activities as $activity) {
      $activity->class_expansion_link = "expansion_link" . $iter;
      $activity->class_attendance = "attendance" . $iter;
      $iter++;
    }
    // dd($activities);
    return view('home')
            ->with('activities', $activities)
            ->with('prev_year', $prev_year)
            ->with('prev_month', $prev_month)
            ->with('next_year', $next_year)
            ->with('next_month', $next_month)
            ->with('this_year', $this_year)
            ->with('this_month', $this_month);
  }

  public function create($year, $month)
  {
    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->get();
    $n_act = count($activities);

    if ($n_act == 0) {
        return redirect('/home/'.$year.'/'.$month)->with('status', "活動予定がまだ登録されていません");
    }

    $parts = Part::orderBy('id')->get();
    // dd('create', $year, $month, $activities, $parts, $n_act);
    return view('create')
            ->with('activities', $activities)
            ->with('n_act', $n_act)
            ->with('parts', $parts)
            ->with('year', $year)
            ->with('month', $month);
  }

  public function store(Request $request)
  {
    $request->name = trim(mb_convert_kana($request->name, 's', 'UTF-8')); // 全角スペースを半角スペースに置換したあと，トリム
    $this->validate($request, [
      'part' => 'required|min:1',
      'name' => 'required|max:30'  // 入力が必須で，最大30文字
    ]);

    $name = $request->name;
    $part = $request->part;
    $n_act = $request->n_act;
    $year = $request->year;
    $month = $request->month;

    // @codeCoverageIgnoreStart
    if (strlen($name)==0) {
      return redirect('/home/'.$year.'/'.$month .'/create')->with('status', "名前が入力されていません");
    }
    // @codeCoverageIgnoreEnd

    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->get();
    // 名前の重複チェック
    foreach ($activities as $activity) {
      $act_id = $activity->id;
      $attens = Attendance::where('activity_id', '=', $act_id)->get();
      foreach ($attens as $atten) {
        if ($atten->name == $name) {
          return redirect('/home/'.$year.'/'.$month .'/create')->with('status', "登録できませんでした！同じ名前の予定が登録済みです");
        }
      }
    }

    // ここで validation
    foreach ($activities as $activity) {
      $obj_name_comment = "comment" . $activity->id;
      $this->validate($request, [
        $obj_name_comment => "max:140"
      ]);
    }

    foreach ($activities as $activity) {
      $obj_name_act = "act" . $activity->id;
      $obj_name_comment = "comment" . $activity->id;
      // var_dump($obj_name, $request->$obj_name);

      $attendance = new Attendance;
      $attendance->name = $name;
      $attendance->activity_id = $activity->id;
      $attendance->attendance = $request->$obj_name_act;
      $attendance->comment = $request->$obj_name_comment;
      $attendance->part_id = $part;

      $attendance->save();
    }
    return redirect('/home/'.$year.'/'.$month)->with('status', $name . " さんの予定を登録しました");
  }

  public function edit($year, $month, $aid)
  {
    $arg_attendance = Attendance::where('id', '=', $aid)->first();
    if (count($arg_attendance)==0) {
      return redirect('/home/'.$year.'/'.$month)->with('status', "不正なURLです");
    }
    $name = $arg_attendance->name;
    $part = $arg_attendance->part_id;

    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

    $attendances = Attendance::select('attendances.*', 'activities.*', 'attendances.id as attendance_id')
                                ->join('activities', 'attendances.activity_id', '=', 'activities.id')
                                ->where('attendances.name', '=', $name)
                                ->where('activities.act_at', '>=', $thismonth_head)
                                ->where('activities.act_at', '<=', $thismonth_tail)
                                ->get();

    if (count($attendances) == 0) {
        return redirect('/home/'.$year.'/'.$month)->with('status', "不正なURLです");
    }
    foreach ($attendances as $attendance) {
      $attendance->id = $attendance->attendance_id;
    }
    // dd($attendances);
    $activities = Activity::where('activities.act_at', '>=', $thismonth_head)
                                ->where('activities.act_at', '<=', $thismonth_tail)
                                ->get();
    $n_act = count($activities);
    $parts = Part::orderBy('id')->get();

    // dd("edit", $year, $month, $aid, $arg_attendance, $name, $part, $attendances);

    return view('edit')
            ->with('activities', $activities)
            ->with('n_act', $n_act)
            ->with('parts', $parts)
            ->with('year', $year)
            ->with('month', $month)
            ->with('name', $name)
            ->with('part_id', $part)
            ->with('aid', $aid)
            ->with('attendances', $attendances);
  }

  public function update(Request $request)
  {

    $part = $request->part;
    $n_act = $request->n_act;
    $year = $request->year;
    $month = $request->month;
    $aid = $request->aid;
    $name = $request->name;

    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

    $attendances = Attendance::select('attendances.*', 'activities.*', 'attendances.id as attendance_id')
                                ->join('activities', 'attendances.activity_id', '=', 'activities.id')
                                ->where('attendances.name', '=', $name)
                                ->where('activities.act_at', '>=', $thismonth_head)
                                ->where('activities.act_at', '<=', $thismonth_tail)
                                ->get();
    foreach ($attendances as $attendance) {
      $attendance->id = $attendance->attendance_id;
    }

    // ここで validation
    foreach ($attendances as $attendance) {
      $obj_name_comment = "comment" . $attendance->id;
      $this->validate($request, [
        $obj_name_comment => "max:140"
      ]);
    }

    // dd($request);

    // $this->validate($request, [
    //   'part' => 'required|min:1',
    //   'name' => 'required|max:100'  // 入力が必須で，最大100文字
    // ]);
    //

    foreach ($attendances as $attendance) {
      $obj_name_atten = "atten" . $attendance->id;
      $obj_name_comment = "comment" . $attendance->id;
      // var_dump($obj_name, $request->$obj_name);
      $atten = Attendance::where('id', '=', $attendance->id)
                            ->first();
      $atten->attendance = $request->$obj_name_atten;
      $atten->comment = $request->$obj_name_comment;
      $atten->part_id = $part;
      $atten->save();

    }
    return redirect('/home/'.$year.'/'.$month)->with('status', $atten->name . " さんの予定を変更しました");
  }

  private function get_Attendances_detail($acts)
  {
    foreach ($acts as $act) {
      // attendance ごとの合計を取得
      $atten = array();
      for ($i = 0 ; $i <= 3; $i++) {
        $atten[]  = Attendance::where('activity_id', '=', $act->id)
                                ->where('attendance', '=', $i)->count();
      }
      // 登録者数の合計
      $atten[] = 0;
      for ($i = 0 ; $i <= 3; $i++) {
        $atten[4]  += $atten[$i];
      }
      $act->n_atten = $atten;

      // パートごと
      foreach ($acts as $act) {
        $parts = Part::orderBy('id')->get();
        foreach ($parts as $part) {
          // 人数を集計する
          $part_atten = array();
          for ($i = 0 ; $i <= 3; $i++) {
            $part_atten[]  = Attendance::where('activity_id', '=', $act->id)
                                    ->where('part_id', '=', $part->id)
                                    ->where('attendance', '=', $i)->count();
          }
          $part->n_atten = $part_atten;
          // 回答のリストを取得
          $part->attendances = Attendance::where('activity_id', '=', $act->id)
                                  ->where('part_id', '=', $part->id)
                                  ->orderBy('updated_at')
                                  ->get();
          // 新規登録と更新情報を設定
          foreach ($part->attendances as $attendance) {
            // 最終更新からの経過時間を分単位で取得する
            $minutes_from_update = (strtotime("now") - strtotime($attendance->updated_at)) / 60;
            // 「新規」と「更新」を初期化
            $attendance->new = false;
            $attendance->update = false;
            // 定数で指定された時間より短ければ「新規」または「更新」を設定する
            if ($minutes_from_update < \Config::get('const.NEW_THRESHOLD')) {
              if ($attendance->created_at == $attendance->updated_at) {
                $attendance->new = true;
              } else {
                $attendance->update = true;
              }
            }
          }

          // コメントをトリミング
          foreach ($part->attendances as $attendance) {
            if (mb_strlen($attendance->comment) > 20) {
              $attendance->comment = mb_substr($attendance->comment, 0, 20) . "...";
            }

          }
      }
        $act->parts = $parts;
      }
    }
    return $acts;
  }
}
