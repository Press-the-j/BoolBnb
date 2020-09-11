<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
  public function flat()
  {
    return $this->belongsTo('App\Flat');
  }

  protected $fillable = [
    'flat_id',
    'view_promoted',
    'ip_user',
    
  ];
}
