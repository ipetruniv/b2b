<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
 
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'products';
    protected $fillable = [ 'code_1c', 'name', 'code_1c_items_group', 
                            'code_1c_categories', 'vendor_code', 'is_visible', 'is_order_enabled' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createProduct($xml) 
    {   
        return  $this->create([
            'code_1c' => $xml->code_1c,
            'name' =>$xml->name,
            'code_1c_items_group' => $xml->code_1c_items_group,
            'code_1c_categories' => $xml->code_1c_categories,
            'vendor_code' => $xml->vendor_code,
            'is_visible'  => $xml->not_visible,
            'is_visible'  => $xml->not_order_enabled,
        ]); 
      
    }

    function getProductPhoto(){
        $src= "/images/products/preview/$this->code_1c/$this->code_1c"."_0.jpg";
        if(file_exists(getcwd().$src))
            return $src;
        else
            return "/images/products/$this->code_1c/$this->code_1c"."_0.jpg";
    }
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateProduct($xml) 
    {
        return $this->where('code_1c', '=', $xml->code_1c)->update([
            'name' =>$xml->name,
            'code_1c_items_group' => $xml->code_1c_items_group,
            'code_1c_categories' => $xml->code_1c_categories,
            'vendor_code' => $xml->vendor_code,
            'is_visible'  => $xml->not_visible,
            'is_visible'  => $xml->not_order_enabled,
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetProduct($code)
    {
        return  $this->where('code_1c', '=', $code)->first();
    }
    
    public function getProduct($id) 
    {
        return $this->where('id', '=', $id)->first();
    }
    
    public function GetProductPrice() 
    {
         return $this->hasmany('App\Models\ProductPrice','code_1c_items', 'code_1c');
    }
    
     public function getProductByNames($name)
     {
         return $this ->where('name', 'LIKE', "%$name%")->get();
     }
     
     public function getCatItemGroup() 
     {
         return  $this->hasOne('App\Models\ItemGroup','items_group_code_1c', 'code_1c_items_group');
     }
     public function getCatProductPrice() 
     {
         return  $this->hasOne('App\Models\ProductPrice','code_1c_items', 'code_1c');
     }
    

     
}
