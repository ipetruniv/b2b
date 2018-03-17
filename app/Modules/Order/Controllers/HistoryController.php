<?php

namespace App\Modules\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Order\Traits\OrderTrait;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Modules\Catalog\Traits\CatalogTrait;
use App\Modules\Order\Models\OrderRow;
use Validator;
use Auth;
use DB;
use App;

class HistoryController extends Controller
{
    use OrderTrait; 
    use UserTrait;
    
    public $users = '';
  
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /**
     * Вивід історій замовлень
     * 
     * @return object
     */
    
    public function HistoryList() 
    {   
        $carts = $this->getUserCartHistory();
        foreach($carts as $cart){
            $total = 0;
            $userCartRow = $cart->getOrderRows;
                foreach($userCartRow as $OrderRow)
                    $total += $OrderRow->price;
            $cart->total=$total;
        }
        return view('Order::historyList')->with([
            'carts'        => $carts,
        ]); 
    }

    
    public function HistoryDetail(Request $request, $lang, $id) 
    {
        $cart = $this->getUserCartHistoryByOrderId($id);
       //
       if(!$cart)
         return redirect(App::getLocale().'/cabinet/history');

        $method_price = $this->getPaymentUserMethod($cart->buyer_user_1c);


        $userCartRow = $cart->getOrderRows;
        $totalSum = $this->getOrderSum($id);


        return view('Order::historyDetail')->with([
            'cart'        => $cart,
            'userCartRow' => $userCartRow,
            'totalSum'    => $totalSum,
            'method_price'    => $method_price,
        ]);
    }
    
    
   
}

