<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['name', 'location', 'food', 'description', 'starttime', 'endtime', 'costs'];
}  