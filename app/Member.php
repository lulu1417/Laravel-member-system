<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable {
	protected $fillable = [
		'email', 'password', 'api_token', 'isAdmin',
	];

}
