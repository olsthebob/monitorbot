<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	protected $guarded = [];

	public $incrementing = false;

	public function site() {
		return $this->belongsTo('App\Site');
	}
}
