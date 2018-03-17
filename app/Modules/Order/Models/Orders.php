<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Orders extends Model
{
    protected $table      = 'orders'; 
    protected $primaryKey = 'id';   
    public    $timestamps = true;
    protected $fillable = [
        'order_user', 'user_1c_id', 'order_sum', 'order_synk_1c', 'order_status',
        'desirable_delivery', 'payment_method', 'person',
        'order_comment', 'order_company', 'order_country', 'order_region', 'agent_id', 'order_phone', 'order_vat', 'order_name', 'order_surname',
        'order_city', 'order_street', 'order_build', 'order_post_code', 'order_email', 'buyer_user_1c','delivery_comment','delivery_address'
    ];
    protected $dates = ['desirable_delivery'];

    const STATUS_NOT_CONFIRM = "300fcfe2-16bd-11e7-bff6-00215a4648ba";
    const STATUS_READY       = "62f4d4b6-2f23-11e7-99b5-00215a4648ba";
    const STATUS_IN_STORAGE = "496e2c00-7413-11e6-b7bd-7824af37f18c";
    const STATUS_RESERVATION = "cdefa9bb-ce87-11e5-8584-005056c00008";
    const STATUS_IN_PRODUCTION = "c26e370a-d4b9-11e6-be0e-7824af37f18c";

    /**
    * Привяза до рядків  
    */   
    public function getOrderRows() 
    {
        return $this->hasMany('App\Modules\Order\Models\OrderRow','order_id', 'id');
    }

    public function getTypeUserPrice() 
    {
        return $this->hasOne('App\Models\User','id', 'order_user');
    }
    
    //get order status
    public function getStatus()
    {
        $history_order_status = DB::table('orders_status')->where('code_1c', '=', $this->order_status)
            ->select('name')
            ->first();
        return $history_order_status->name;
    }

    public function OrderNotEdit()
    {
        return ($this->order_status == $this::STATUS_IN_STORAGE || $this->order_status == $this::STATUS_READY)?TRUE:FALSE;
    }

    public function OrderStorage100()
    {
        return ($this->order_status == $this::STATUS_RESERVATION || $this->order_status == $this::STATUS_IN_PRODUCTION)?TRUE:FALSE;
    }
    
    public function getByers() 
    {
         return $this->hasOne('App\Models\User','id', 'order_user');     
    }
    
     public function getAgent() 
    {
         return $this->hasOne('App\Models\User','user_code_1c', 'agent_id');     
    }
    
    
    public function getByersOrder() 
    {
         return $this->hasOne('App\Models\User','user_code_1c', 'buyer_user_1c');     
    }
          
}
