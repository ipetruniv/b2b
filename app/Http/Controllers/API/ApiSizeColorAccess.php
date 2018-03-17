<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SizeColorAccess;
use Validator;
use DB;


class ApiSizeColorAccess extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddSizeColor() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $product = new SizeColorAccess();
            $prod_del =  $product->cleanTable();
            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю | {$row}",
                    ];
                   continue; 
                }

                $product->createSizeColor($row);
            
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
    
    
    
    
    public function ValidPostData($data) 
    {
        if(isset($data->code_1c_items)) { 
          return true;
        } else {
          return false;
        }
    
    }

}