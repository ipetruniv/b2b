<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $fillable = [ 'charact_code_1c', 'name' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createCharacteristic($xml) 
    {   
        return  $this->create([
            'charact_code_1c' => $xml->code_1c,
            'name'            => $xml->name,
        ]); 
      
    }
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateCharacteristic($xml) 
    {
        return $this->update([
            'charact_code_1c' => $xml->code_1c,
            'name'            => $xml->name,
        ]);

    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetCharacteristics($code)
    {
        return  $this->where('charact_code_1c', '=', $code)->first();
        
    }
    
    
    public function getCharacteristicValue() 
    {
       return $this->hasMany('App\Models\CharacteristicValue', 'code_1c_characteristic', 'charact_code_1c');
    }
    
}
