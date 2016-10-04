<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'openid',
        'school_id',
        'nickname',
        'sex',
        'avatar',
        'phone',
    ];

    public function songs()
    {
        return $this->hasMany('App\Song');
    }

    public function school()
    {
        return $this->belongsTo('App\School');
    }
}
