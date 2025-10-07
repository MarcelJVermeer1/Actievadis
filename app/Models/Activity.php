<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
  protected $fillable = [
    'name',
    'location',
    'food',
    'description',
    'starttime',
    'endtime',
    'costs',
    'min',
    'necessities',
    'image',
  ];

  public $incrementing = false;
  public static function boot()
  {

    parent::boot();

    static::creating(function ($model) {
      $model->id = Str::uuid();
    });
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'enrolled', 'activity_id', 'user_id')
      ->withTimestamps();
  }
}
