<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
  // One to Many の One 側
  public function activities()
  {
    return $this->hasMany('App\Activity');
  }
}
