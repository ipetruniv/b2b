<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Remains extends Model
{
   /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'remains';
    protected $fillable = [ 'code_1c_items_remains', 'name_items', 'code_1c_consignment', 
         'name_consignment', 'code_1c_storage', 'name_storage', 'code_1c_characteristic_size',
        'name_characteristic_size', 'code_1c_characteristic_size_value', 'name_characteristic_size_value',
        'code_1c_characteristic_color', 'name_characteristic_color', 'code_1c_characteristic_color_value',
        'name_characteristic_color_value', 'remains'];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createRemains($xml) 
    {   
        return  $this->create([
            'code_1c_items_remains' => $xml->code_1c_items,
            'name_items'            =>$xml->name_items,
            'code_1c_consignment'   => $xml->code_1c_consignment,
            'name_consignment'      => $xml->name_consignment,
            'code_1c_storage'       => $xml->code_1c_storage,
            'name_storage'          => $xml->name_storage,
            'code_1c_characteristic_size'  => $xml->code_1c_characteristic_size,
            'name_characteristic_size'     =>$xml->name_characteristic_size,
            'code_1c_characteristic_size_value'  =>$xml->code_1c_characteristic_size_value,
            'name_characteristic_size_value'     =>$xml->name_characteristic_size_value,
            'code_1c_characteristic_color'       =>$xml->code_1c_characteristic_color,
            'name_characteristic_color'          =>$xml->name_characteristic_color,
            'code_1c_characteristic_color_value' =>$xml->code_1c_characteristic_color_value,
            'name_characteristic_color_value'    =>$xml->name_characteristic_color_value,
            'remains' => $xml->remains,
        ]); 
      
    } 
    
    public function cleanTable() 
    {
       return  $this->truncate();
    }
    
}