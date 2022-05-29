<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Auction;


class AdminRequest extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
    * The user that made this request
    */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
    * The admin this request is for
    */
    public function admin() {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }

}