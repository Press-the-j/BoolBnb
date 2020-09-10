<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  public function flat()
  {
    return $this->belongsTo('App\Flat');
  }

  protected $fillable = [
    'flat_id',
    'email_sender',
    'content',
    'is_read',
  ];
}
