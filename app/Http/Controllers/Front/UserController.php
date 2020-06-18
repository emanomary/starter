<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('showUserName2');

    }

    public function showUserName()
    {
        return 'Eman Kullab';
    }

    public function showUserName2()
    {
        return 'Mohammed Omari';
    }
}
