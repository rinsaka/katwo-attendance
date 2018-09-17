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
    $activities = Activity::get();

    foreach ($activities as $activity) {
      var_dump($activity->place->place);
    }

    return view('home');
  }
}
