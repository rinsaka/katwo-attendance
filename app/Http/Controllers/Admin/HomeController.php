<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Activity;
use App\Time;
use App\Place;

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
    $activity = Activity::where('id', '=', $request->aid)->first();
    if (!$activity) {
      return redirect('/admin/home/')->with('status', "そのような活動予定がありません");
    }

    $activity->act_at = $request->act_at;
    $activity->time_id = $request->time;
    $activity->place_id = $request->place;
    $activity->save();
    return redirect('/admin/home/')->with('status', $request->act_at . "の活動予定を修正しました");
    // dd($request, $request->aid, $request->act_at, $request->time, $request->place, $activity);
  }
}
