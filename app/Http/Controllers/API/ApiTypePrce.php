<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class ApiTypePrce extends Controller
{

    /**
     * Створення нових з 1с
     * 
     * @param Request $request
     * @return object
     */
    public function AddTypePrce() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            foreach( $rezult as $row ) {
                if(!$this->IsIssetTypePrce($row->code_1c)) {
                    $this->createTypePrce($row);
                } else {
                    $this->updateTypePrce($row);  
                   // continue;
                }  
            }
            if($rezult) {
                return response()->json(['status' =>'OK']);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST']);
        }
    } 
    
  
    
     /**
     * @param string $email
     * @return boolean
     */
    public function IsIssetTypePrce($code)
    {
        return  DB::table('type_price')->where('code_1c', '=', $code)->first();
        
    }
    

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createTypePrce($xml) 
    {   
        return DB::table('type_price')->insert([
            'code_1c'    => $xml->code_1c,
            'name'       => $xml->name,
            'code_1c_currency'  => $xml->code_1c_currency,
        ]); 
      
    }
    
    /**
     * 
     * @param object $xml
     * @return boolean
     */
    public function updateTypePrce($xml) 
    {
        return DB::table('type_price')->where('code_1c', '=', $xml->code_1c)->update([
            'code_1c_currency'    => $xml->code_1c_currency,
            'name'       => $xml->name,
        ]); 
    }
}