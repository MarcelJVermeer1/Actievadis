<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityGuest extends Model
{
    protected $fillable = [
        'activity_id', 'name', 'email', 'phone', 
        'status', 'email_verified_at', 'verification_token'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->id = (string) Str::uuid());
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}

