<?php

namespace App\Modules\Order\Widgets;
use App\Modules\Widgets\Contract\ContractWidget;
use App\Http\Controllers\Controller;
use App\Modules\Order\Traits\OrderTrait;

use DB;

class CartWidgets extends Controller implements ContractWidget
{
    use OrderTrait;
  
   /**
    * Виджет вивода корзини в шапці
    * 
    * @return object
    */

    public function execute()
    {  

        $cartCount = $this->getUserCart();
        ($cartCount) ? $count =  $cartCount->getOrderRows->sum('count') : $count = 0;
        
        return  View('Widgets::Cart', [
            'cartCount'  => $count,
        ]);
        
    }

}