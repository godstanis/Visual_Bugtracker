<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function setLang($lang)
    {

        if (array_key_exists($lang, config('languages'))) {

            setcookie ('applocale', $lang, 0, '/', NULL, 0 ); 
            
        }
        return Redirect::back();

    }
}
