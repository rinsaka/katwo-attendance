<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  // One to Many の Many 側
  public function place()
  {
    return $this->belongsTo('App\Place');
  }

  // One to Many の Many 側
  public function time()
  {
    return $this->belongsTo('App\Time');
  }

  // One to Many の One 側
  public function attendances()
  {
    return $this->hasMany('App\Attendance');
  }
}
