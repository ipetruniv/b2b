<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storages extends Model 
{
  /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'storages';
    protected $fillable = ['storages_code_1c', 'name'];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createStorages($xml) 
    {   
        return  $this->create([
            'storages_code_1c' => $xml->code_1c,
            'name' =>$xml->name,
        ]); 
      
    } 
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateStorages($xml) 
    {
        return $this->where('storages_code_1c', '=', $xml->code_1c)->update([
            'name' =>$xml->name,
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetStorages($code)
    {
        return  $this->where('storages_code_1c', '=', $code)->first();
    }
    
    
}
