<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function users() {
        return $this->hasMany('App\User');
    }

    public function sites() {
        return $this->hasMany('App\Site');
    }

    public function alerts() {
        return $this->hasMany('App\Alert');
    }
}
