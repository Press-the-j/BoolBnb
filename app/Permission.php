<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  public function users()
  {
    return $this->belongsToMany('App\User');
  }

  public function roles()
  {
    return $this->belongsToMany('App\Role');
  }
}
