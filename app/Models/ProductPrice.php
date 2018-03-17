<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
 
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'product_price';
    protected $fillable = [ 'code_1c_items', 'code_1c_price_type', 'price_value' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createProductPrice($xml) 
    {   
        return  $this->create([
            'code_1c_items' => $xml->code_1c_items,
            'code_1c_price_type' =>$xml->code_1c_price_type,
            'price_value' => $xml->price_value,
        ]); 
      
    } 
    
    public function GetPriceUser() 
    {
          return $this->hasOne('App\Models\User','type_price', 'code_1c_price_type');
    }
    
    
    
    /**
     * @param object $xml
     * @return object
     */
//    public function updateProduct($xml) 
//    {
//        return $this->where('code_1c', '=', $xml->code_1c)->update([
//            'name' =>$xml->name,
//            'code_1c_items_group' => $xml->code_1c_items_group,
//            'code_1c_categories' => $xml->code_1c_categories,
//            'vendor_code' => $xml->vendor_code,
//        ]);
//    }
    
     /**
     * @param string $code
     * @return boolean
     */
//    public function IsIssetProduct($code)
//    {
//        return  $this->where('code_1c', '=', $code)->first();
//    }
    
    
   
}
