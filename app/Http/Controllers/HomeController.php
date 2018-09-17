<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;


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
            ->with('next_month', $next_month);
  }

  public function show($year, $month)
  {
    $thismonth_head = date("Y-m-01", mktime(0,0,0,$month,1,$year));
    $thismonth_tail = date("Y-m-t", mktime(0,0,0,$month,1,$year));

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
            ->with('next_month', $next_month);
  }
}
