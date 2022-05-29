<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;


class UserFollow extends Pivot
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $attributes = [
        'followed_id' => 0,
        'follower_id' => 0
    ];

    public function followed(){
        return $this->hasOne('App\Models\User', 'followed_id');
    }

    public function follower(){
        return $this->hasOne('App\Models\User', 'follower_id');
    }
}