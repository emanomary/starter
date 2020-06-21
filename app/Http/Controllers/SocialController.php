<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //login with facebook
    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    //callback the home page
    public function callback($service)
    {
        $user = Socialite::with($service)->user();
        return response()->json($user);
    }
}
