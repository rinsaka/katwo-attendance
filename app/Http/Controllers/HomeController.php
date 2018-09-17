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

    $thismonth_head = date('Y-m-01',time());
    $thismonth_tail = date('Y-m-t',time());
    // dd($thismonth_head, $thismonth_tail);

    $activities = Activity::where('act_at', '>=', $thismonth_head)
                            ->where('act_at', '<=', $thismonth_tail)
                            ->get();
    return view('home')
            ->with('activities', $activities);
  }
}
