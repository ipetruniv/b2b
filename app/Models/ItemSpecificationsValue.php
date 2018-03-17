<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Common;
class ItemSpecificationsValue extends Model
{
    use Common;
    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'item_specifications_value';
    protected $fillable = [ 'code_1c_items','code_1c_Item_specifications' ];
    public $timestamps  = false;

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createSpVal($xml) 
    {   
        return  $this->create([
            'code_1c_items' => $xml->code_1c_items,
            'code_1c_Item_specifications' =>$xml->code_1c_Item_specifications
        ]); 
      
    } 
    
    /**
     * @param object $xml
     * @return object
     */
    public function updateSpVal($xml) 
    {
        return $this->where('code_1c_items', '=', $xml->code_1c_items)->update([
            'code_1c_Item_specifications' =>$xml->code_1c_Item_specifications
        ]);
    }
    
     /**
     * @param string $code
     * @return boolean
     */
    public function IsIssetSpVal($code)
    {
        return  $this->where('code_1c_Item_specifications', '=', $code)->first();
    }
    
    
   
}
