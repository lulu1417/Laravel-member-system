<?php

namespace App\Http\Controllers;

use Str;
use App\Member;
use Illuminate\Http\Request;

class LoginController
{
    public function login(Request $request)
    {
        $member = Member::where('email', $request->email)->where('password', $request->password)->first();
        $apiToken = Str::random(10);
        if($member){
            if ($member->update(['api_token'=>$apiToken])) { //update api_token
                if ($member->isAdmin)
                    return "login as admin, your api token is $apiToken";
                else
                    return "login as user, your api token is $apiToken";
            }
        }else return "Wrong email or password！";

    }
}
