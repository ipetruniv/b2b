<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CharacteristicValue;
use Validator;
use DB;


class ApiCharacteristicValue extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddCharacteristicValue() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $charactVal = new CharacteristicValue();
            foreach( $rezult as $row ) {
                if(!$charactVal->IsIssetCharacteristicsVal($row->code_1c)) {
                    $charactVal->createCharacteristicVal($row);
                } else {
                    $charactVal->updateCharacteristicVal($row);
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