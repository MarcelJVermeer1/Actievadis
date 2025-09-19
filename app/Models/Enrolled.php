<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolled extends Model
{
    protected $table = 'enrolled';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'activity_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
