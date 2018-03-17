<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeColorAccess extends Model
{
 
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'size_color_access';
    protected $fillable = [ 'code_1c_prod', 'code_1c_characteristic', 
                            'code_1c_characteristic_value', 'not_enabled'];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createSizeColor($xml) 
    {   
        return  $this->create([
            'code_1c_prod' => $xml->code_1c_items,
            'code_1c_characteristic' =>$xml->code_1c_characteristic,
            'code_1c_characteristic_value' => $xml->code_1c_characteristic_value,
            'not_enabled' => $xml->not_enabled,  
        ]); 
      
    } 
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateSizeColor($xml) 
    {
        return $this->where('code_1c_prod', '=', $xml->code_1c_items)->update([
            'code_1c_characteristic' =>$xml->code_1c_characteristic,
            'code_1c_characteristic_value' => $xml->code_1c_characteristic_value,
            'not_enabled' => $xml->not_enabled,  
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetSizeColor($code)
    {
        return  $this->where('code_1c_prod', '=', $code)->first();
    }
    
    public function cleanTable() 
    {
       return  $this->truncate();
    }
   
    
    
     public function getCharacterVal() 
    {
        return $this->hasMany('App\Models\CharacteristicValue','code_1c_characteristic', 'code_1c_characteristic');
    }
    
    
}
