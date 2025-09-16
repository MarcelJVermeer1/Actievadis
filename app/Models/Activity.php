<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'location', 'food', 'description', 'starttime', 'endtime', 'costs'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrolled', 'activity_id', 'user_id')
            ->withTimestamps();
    }
}
