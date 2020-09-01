<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
  public function flats()
  {
    return $this->belongsToMany('App\Flat');
  }
}
