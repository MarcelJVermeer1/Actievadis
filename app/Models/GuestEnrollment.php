<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GuestEnrollment extends Model {
    protected $table = 'guest_enrollments';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'activity_id',
        'name',
        'email',
        'verified',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
