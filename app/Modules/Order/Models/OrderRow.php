<?php

namespace App\Modules\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRow extends Model
{
    protected $table      = 'order_row'; 
    protected $primaryKey = 'id';   
    public    $timestamps = true;
    protected $fillable = [
        'order_id', 'product_1c', 'count', 'price', 
        'price_sum', 'comment', 'color', 'size', 'store',
        'product_name','id_1c_color', 'id_1c_store', 'id_1c_size','discount'
        
    ];
 
}
