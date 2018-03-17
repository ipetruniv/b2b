<?php
namespace  App\Traits;
use App\Http\Controllers\Controller;
use DB;


trait Common {
  
     public function decodeName($name) {
        return  iconv("UTF-8", "CP1251", $name); 
    }


    public function SendMail($data){
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . ' b2bclientssystem ' . " <" . ' b2bclientssystem ' . ">\r\n";
        $email = $data['email'];
        $text = view('email')->with('data', $data)->render();
        if ( mail( $email, $data['theme'], $text, $headers ) ){
            return TRUE;
        }else{
        	die('email send error');
        }
    }
    
}