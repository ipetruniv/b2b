<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacteristicValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'characteristic_value';
    protected $fillable = [ 'code_1c', 'code_1c_characteristic', 'value' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createCharacteristicVal($xml) 
    {   
        return  $this->create([
            'code_1c' => $xml->code_1c,
            'code_1c_characteristic' => $xml->code_1c_characteristic,
            'value' => $xml->value,
        ]); 
      
    }
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateCharacteristicVal($xml) 
    {
        return  $this->where('code_1c', '=', $xml->code_1c)->update([
            'code_1c_characteristic' => $xml->code_1c_characteristic,
             'value' => $xml->value,
        ]);

    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetCharacteristicsVal($code)
    {
        return  $this->where('code_1c', '=', $code)->first();
        
    }

}
