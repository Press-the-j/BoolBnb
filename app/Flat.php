<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


class Flat extends Model
{


  use SpatialTrait;

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
    return $this->belongsToMany('App\Promotion')->withPivot('started_at', 'end_at');
  }

  protected $spatialFields = [
    //deve essere il nome della colonna in cui mettiamo le coordinate
    'position'
  ];

  protected $fillable = [
    'user_id',
    'title',
    'slug',
    'position',
    'is_promoted',
    'is_hidden',
  ];
}
