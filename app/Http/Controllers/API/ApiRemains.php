<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Remains;
use Validator;
use DB;


class ApiRemains extends Controller
{
   

    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddRemains() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $clear = DB::table('remains')->delete();
            $remains = new Remains();
            $remains_del =  $remains->cleanTable();
            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю {$row}",
                    ];
                   continue; 
                }

                $remains->createRemains($row);
            
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
        if(isset($data->code_1c_items, $data->code_1c_consignment,
                 $data->code_1c_storage, $data->code_1c_characteristic_size,  
                 $data->code_1c_characteristic_color,
                 $data->code_1c_characteristic_color_value )) { 
          return true;
        } else {
          return false;
        }
    
    }

}