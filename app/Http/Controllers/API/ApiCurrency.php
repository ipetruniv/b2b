<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class ApiCurrency extends Controller
{

    /**
     * Створення нових з 1с
     * 
     * @param Request $request
     * @return object
     */
    public function AddCurrency() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            foreach( $rezult as $row ) {
                if(!$this->IsIssetCurrency($row->code_1c)) {
                    $this->createCurrency($row);
                } else {
                    $this->updateCurrency($row);  
                  //  continue;
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
    public function IsIssetCurrency($code)
    {
        return  DB::table('currency')->where('code_1c', '=', $code)->first();
        
    }
    

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createCurrency($xml) 
    {   
        return DB::table('currency')->insert([
            'code_1c'    => $xml->code_1c,
            'name'       => $xml->name,
            'full_name'  => $xml->full_name,
            'code'       => $xml->code,
        ]); 
      
    }
    
    /**
     * 
     * @param object $xml
     * @return boolean
     */
    public function updateCurrency($xml) 
    {
        return DB::table('currency')->where('code_1c', '=', $xml->code_1c)->update([
            'name'       => $xml->name,
            'full_name'  => $xml->full_name,
            'code'       => $xml->code,
        ]); 
    }
}