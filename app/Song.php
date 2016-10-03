<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'dail_times',
    ];

    protected $dates = [
        'deleted_at',
        'healed_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
