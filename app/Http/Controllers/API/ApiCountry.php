<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;


class ApiCountry extends Controller
{
  

    /**
     * Створення нових з 1с
     * 
     * @param Request $request
     * @return object
     */
    public function InsertNewCountry() 
    {
          if(isset($_POST['xml'])) {   
              $rezult = simplexml_load_string($_POST['xml']);
              
              foreach($rezult as $row) {
                 $rezult = $this->createCounty($row);
              }
 
              if($rezult) {
                  return response()->json(['status' => 'OK']);
              } else {
                  return response()->json(['errors' => 'ERROR_SQL'], 422);
              }
          } else {
              return response()->json(['errors' => 'ERROR_POST']);
          }
      } 
    
    
    
    /**
     * 
     * @param object $xml
     * @return object
     */
    public function createCounty($xml) 
    {
        if($this->IsIssetCountry($xml->code)) {
            return  $sql = DB::table('countries')->insert([
                'name'         => $xml->name,
                'code'         => $xml->code,
                'code_alpha_1' => $xml->code_alpha_1,
                'code_alpha_2' => $xml->code_alpha_2,
                'code_alpha_3' => $xml->code_alpha_3,
                'full_name'    => $xml->full_name,
            ]); 
        } 
    }
    
    /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetCountry($code)
    {
         $countries = DB::table('countries')->where('code', '=', $code)->first();
         if(isset($countries->code)){
           return false;
         } else {
             return true;
         }
    }

}