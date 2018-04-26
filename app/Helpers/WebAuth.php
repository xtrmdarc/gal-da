<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use App\User;

class WebAuth
{
    public static function isLoggedIn()
    {
        if(Session::has('Auth.User') && Session::get('Auth.User') instanceof \App\User)
        {
            return true;
        }
        return false;
    }

    public static function getLoggedInUser()
    {
        if(self::isLoggedIn())
        {
            return Session::get('Auth.User');
        }else{
            return null;
        }
    }
}
