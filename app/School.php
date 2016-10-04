<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        //
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
