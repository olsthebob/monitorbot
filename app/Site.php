<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function tests() {
        return $this->hasMany('App\Test');
    }

    public function alerts() {
        return $this->hasMany('App\Alert');
    }

}
