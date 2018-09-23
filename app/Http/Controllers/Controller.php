<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  // 日付の文字列から曜日を返す
  public function get_youbi($str_time)
  {
    $week = array( "日", "月", "火", "水", "木", "金", "土" );
    $timestamp = strtotime($str_time);
    $youbi = $week[date('w', $timestamp)];
    return "(" . $youbi . ")";
  }
}
