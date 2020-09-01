<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlatInfo extends Model
{
  public function flat()
  {
    return $this->belongsTo('App\Flat');
  }
}
