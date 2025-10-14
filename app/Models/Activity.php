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
    'max_capacity',
    'visibility',
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

     public function getImageSrcAttribute()
    {
        return $this->image
            ? 'data:image/jpeg;base64,' . base64_encode($this->image)
            : null;
    }

  public function users()
  {
    return $this->belongsToMany(User::class, 'enrolled', 'activity_id', 'user_id')
      ->withTimestamps();
  }

  public function guestUsers()
  {
    return $this->belongsToMany(Activity::class, 'guest_enrollments')
      ->withPivot('id', 'created_at', 'updated_at', 'name', 'email');
  }

  public function enrolled()
  {
    return $this->hasMany(Enrolled::class, 'activity_id');
  }



}
