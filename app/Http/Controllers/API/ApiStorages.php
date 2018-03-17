<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Storages; 

class ApiStorages extends Controller 
{
    
    /**
     * Створення нових з 1с
     * 
     * @param $_POST['xml']
     * @return object
     */
    public function AddStorages() 
    {
        if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            $storage = new Storages();
            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю | {$row}",
                    ];
                   continue; 
                }
                
                if(!$storage->IsIssetStorages($row->code_1c)) {
                    $storage->createStorages($row);
                } else {
                    $storage->updateStorages($row);
                }  
            }
            if($rezult) {
                return response()->json(['status' =>$err ?? 'OK'  ], 200);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
        } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
        }
    } 
    
    
    
    
    public function ValidPostData($data) 
    {
        if(isset($data->code_1c, $data->name)) { 
            return true;
        } else {
            return false;
        }
    }
}
