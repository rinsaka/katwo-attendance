<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  // One to One
  public function activity()
  {
    return $this->belongsTo('App\Activity');
  }
}
