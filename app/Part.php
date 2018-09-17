<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
  // One to Many の One 側
  public function attendances()
  {
    return $this->hasMany('App\Attendance');
  }
}
