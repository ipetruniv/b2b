<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ItemGroup;
use Validator;
use DB;


class ApiItemGroup extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddItemGroup() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $item = new ItemGroup();
            foreach( $rezult as $row ) {
                if(!$item->IsIssetItemGroup($row->code_1c)) {
                    $item->createItemGroup($row);
                } else {
                    $item->updateItemGroup($row);
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