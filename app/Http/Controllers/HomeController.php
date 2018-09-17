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

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->get();
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
                            ->get();
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
    $this->validate($request, [
      'name' => 'required|max:100'  // 入力が必須で，最大100文字
    ]);

    $name = $request->name;
    $part = $request->part;
    $n_act = $request->n_act;
    $year = $request->year;
    $month = $request->month;

    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->get();

    foreach ($activities as $activity) {
      $obj_name = "act" . $activity->id;
      // var_dump($obj_name, $request->$obj_name);

      $attendance = new Attendance;
      $attendance->name = $name;
      $attendance->activity_id = $activity->id;
      $attendance->attendance = $request->$obj_name;
      $attendance->part_id = $part;
      $attendance->save();
    }

    return redirect('/home/'.$year.'/'.$month)->with('status', "登録しました");

    // dd($request, $name, $part, $n_act, $year, $month, $activities);
  }
}
