<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    public function flatInfo()
    {
      return $this->hasOne('App\FlatInfo');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function views()
    {
      return $this->hasMany('App\View');
    }

    public function messages()
    {
      return $this->hasMany('App\Message');
    }
    
    public function services()
    {
      return $this->belongsToMany('App\Service');
    }

    public function promotions()
    {
      return $this->belongsToMany('App\Promotion');
    }
}
