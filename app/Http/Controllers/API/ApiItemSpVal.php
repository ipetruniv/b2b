<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemSpecificationsValue;
use Validator;
use DB;


class ApiItemSpVal extends Controller
{

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddSpVal() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $item = new ItemSpecificationsValue();
            foreach( $rezult as $row ) {
                if(!$item->IsIssetSpVal($row->code_1c_Item_specifications)) {
                    $item->createSpVal($row);
                } else {
                    $item->updateSpVal($row);
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