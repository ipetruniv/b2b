<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use Validator;
use DB;


class ApiProductPrice extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddProductPrice() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $clear = DB::table('product_price')->delete();
            $productPr = new ProductPrice();

            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю |",
                    ];
                   continue; 
                } else {
                       $productPr->createProductPrice($row);
                }
            }
            if($rezult) {
                return response()->json(['status' => 'OK'  ], 200);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
        }
    } 
    
    
    
    
    public function ValidPostData($data) 
    {
        if(isset($data->code_1c_items, $data->code_1c_price_type, $data->price_value)) { 
          return true;
        } else {
          return false;
        }
    
    }

}