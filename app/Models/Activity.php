<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $fillable = ['name', 'location', 'food', 'description', 'starttime', 'endtime', 'costs'];

    public $incrementing = false;
    protected $keyType = 'string'; 
    public static function boot() {
      
      parent::boot();
      
      static::creating(function ($model) {
        $model->id = Str::uuid();
      });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrolled', 'activity_id', 'user_id')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function guests()
    {
        return $this->hasMany(ActivityGuest::class);
    }
}
