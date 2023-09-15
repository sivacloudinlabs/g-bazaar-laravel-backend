<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'user_id',
        'activity_id',
        'activity_type',
        'id',
        'log'
    ];

    protected $appends = [
        'user',
        'data'
    ];

    public function getUserAttribute()
    {
        return User::where('id', $this->user_id)->first(['name', 'email', 'number']);  
    }

    public function getDataAttribute()
    {
        return json_decode($this->log, true);  
    }
    
}
