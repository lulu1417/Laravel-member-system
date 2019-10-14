<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
use Str;

class LoginController extends Controller {
	public function login(Request $request) {
		$member = Member::where('email', $request->auth_email)->where('password', $request->auth_password)->first();
		$apiToken = Str::random(10);
		dd($member);
		if ($member->update(['api_token' => $apiToken])) {
			//update api_token
			if ($member->isAdmin) {
				return "login as admin, your api token is $apiToken";
			} else {
				return "login as user, your api token is $apiToken";
			}

		}
	}
}
