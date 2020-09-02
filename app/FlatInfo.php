<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlatInfo extends Model
{
  public function flat()
  {
    return $this->belongsTo('App\Flat');
  }

  protected $fillable = [
    'flat_id',
    'image_path',
    'description',
    'city',
    'address',
    'postal_code',
    'square_meters',
    'price',
    'max_guest',
  ];
}