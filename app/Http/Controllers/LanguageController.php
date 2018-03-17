<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Config;
use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang()
    {
        return view('test-lang');

        dd(\Session::get('locale'));
//        if (in_array($lang, \Config::get('app.locales'))) {
//            Session::put('locale', $lang);
//            App::setLocale($lang);
//        }
//        return redirect("/test-lang");
    }
};