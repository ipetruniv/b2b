<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersStatus extends Model
{
 
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'orders_status';
    protected $fillable = [ 'code_1c', 'name' ];
    public $timestamps  = false;
    protected $primaryKey ="code_1c";

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createStatus($xml) 
    {   
        return  $this->create([
            'code_1c' => $xml->code_1c,
            'name'    =>$xml->name,
        ]); 
      
    } 
    

    
   
}
