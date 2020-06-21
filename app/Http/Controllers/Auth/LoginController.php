<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //to login in mobile no.
    public function username()
    {
        $value = request()->input('identify');

        //to know if value email or mobile
        $field = filter_var($value,FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        /*$field = '';
        if(filter_var($value,FILTER_VALIDATE_EMAIL))
            $field = 'email';
        else
            $field = 'mobile';*/

        request()->merge([$field => $value]);

        return $field;
    }
}
