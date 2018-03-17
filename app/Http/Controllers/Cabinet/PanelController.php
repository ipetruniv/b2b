<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
  
    public function Panel()
    {
        return view('cabinet.panel');
    }

}




