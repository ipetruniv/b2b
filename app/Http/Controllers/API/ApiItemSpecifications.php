<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemSpecifications;
use Validator;
use DB;


class ApiItemSpecifications extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddItemSpecifications() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $item = new ItemSpecifications();
            foreach( $rezult as $row ) {
                if(!$item->IsIssetItem($row->code_1c)) {
                    $item->createItem($row);
                } else {
                    $item->updateItem($row);
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