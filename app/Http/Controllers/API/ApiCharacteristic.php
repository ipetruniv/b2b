<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use Validator;
use DB;


class ApiCharacteristic extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddCharacteristic() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $charact = new Characteristic();
            foreach( $rezult as $row ) {
                if(!$charact->IsIssetCharacteristics($row->code_1c)) {
                    $charact->createCharacteristic($row);
                } else {
                    $charact->updateCharacteristic($row);
                }  
            }
            if($rezult) {
                return response()->json(['status' =>'OK'], 200);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
        }
    } 

}