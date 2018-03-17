<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use Validator;
use DB;


class ApiProduct extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddProduct() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $product = new Products();
            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю | {$row}",
                    ];
                   continue; 
                }
                
                if(!$product->IsIssetProduct($row->code_1c)) {
                    $product->createProduct($row);
                } else {
                    $product->updateProduct($row);
                }  
            }
            if($rezult) {
                $this->weightProduct();
                return response()->json(['status' =>$err ?? 'OK'  ], 200);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
        }
    } 
    
    
    public function weightProduct() 
    {
      $weight_prod = DB::table('products')->orderBy('name','ASC')->get();
      $i = 1;
      foreach($weight_prod as $row ) {

        $update = DB::table('products')->where('id','=',$row->id)->update([
            'weight_sort' => $i,
        ]);
       $i++; 
      }
      
    }
    
    public function ValidPostData($data) 
    {
        if(isset($data->code_1c, $data->name, $data->code_1c_items_group, $data->code_1c_categories)) { 
          return true;
        } else {
          return false;
        }
    
    }

}