<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Lang;
use App;
use DB;

class IndexController extends Controller
{
    public function Home() 
    {   
        if(isset(Auth::user()->id)) {
          return redirect(App::getLocale()."/catalog");
          
        } else {
            return redirect(App::getLocale().'/login');
        }
    }

}




