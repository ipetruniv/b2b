<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'categories';
    protected $fillable = [ 'code_1c','name' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createCat($xml) 
    {   
        return  $this->create([
            'code_1c' => $xml->code_1c,
            'name' =>$xml->name
        ]); 
      
    } 
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateCat($xml) 
    {
        return $this->where('code_1c', '=', $xml->code_1c)->update([
            'name' =>$xml->name
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetCat($code)
    {
        return  $this->where('code_1c', '=', $code)->first();
    }
    
    
   
}
