<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function flats()
    {
      return $this->belongsToMany('App\Flat');
    }
}
