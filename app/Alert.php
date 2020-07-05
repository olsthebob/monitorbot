<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $guarded = [];

    public $incrementing = false;

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function site() {
        return $this->belongsTo('App\Site');
    }
}
