<?php

namespace App\Modules\Order\Traits;
use App\Modules\Order\Models\Orders;
use App\Modules\Order\Models\OrderRow;
use App\Models\User;
use Auth;
use DB;
use Session;


trait OrderTrait 
{
    
   /*
    * Отримання даних по продукту на складі
    * 
    * @param string $storeges_id
    * return object
    */
    private function getStoragesById($request) 
    {
        return DB::table('remains')
                ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
                ->leftJoin('products','remains.code_1c_items_remains', '=', 'products.code_1c' )
                ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                ->where('remains.code_1c_items_remains', '=', $request->product)
                ->where('remains.name_characteristic_color_value', '=', $request->color)
                ->where('remains.name_characteristic_size_value', '=', $request->size)
                //TODO Вибір складу по ід складу а вибирав по атрибутах
                ->where('code_1c_storage','=',$request->storage)
                ->first();
    }


    function getStorageProduct($request){
      $buyer = Session::get('buyer');
      return DB::table('remains')
              ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
              ->leftJoin('products','remains.code_1c_items_remains', '=', 'products.code_1c' )
              ->where('pp.code_1c_price_type', '=', $buyer->type_price)
              ->where('remains.code_1c_items_remains', '=', $request->product)
              ->where('remains.name_characteristic_color_value', '=', $request->color)
              ->where('remains.name_characteristic_size_value', '=', $request->size)
              //TODO Вибір складу по ід складу а вибирав по атрибутах
              ->where('code_1c_storage','=',$request->storage)
              ->first();
    }

   /*
    * Створення або оновлення корзини 
    * @param object $storages
    * 
    * return object
    */
    private function cartPush() 
    {
        $buyer = Session::get('buyer');
        $sql = Orders::firstOrCreate([
            'order_user'   => Auth::user()->id,
            'user_1c_id'   => Auth::user()->user_code_1c,
            'order_status' => '300fcfe2-16bd-11e7-bff6-00215a4648ba',
            'buyer_user_1c' => $buyer->user_code_1c
        ]);
        return $sql;
    }
    
    
    /**
     * Оновлення  позиції замовлення
     * 
     * @param string $productCart
     * @param   $countRow
     * @return object
     */
    
    
      private function productUpdate($productCart, $countRow) 
      { 
        $update = OrderRow::where('order_id', '=', $productCart->order_id)
                      ->where('product_1c', '=', $productCart->product_1c)
                      ->where('store', '=', $productCart->store)
                      ->where('color', '=', $productCart->color)
                      ->where('size',  '=', $productCart->size)
                      ->update([
                          'count'     => $countRow,
                          'price'     => $productCart->price,
                          'price_sum' => $productCart->price * $countRow + 1,
                      ]);
        return $update;
      }
    
      
      
      /**
     * Вставка позиції замовлення
     * 
     * @param string $productCart
     * @param   $countRow
     * @return object
     */
    
    
      private function productInsert($storages, $cart_id, $request,$product = null)
      {
        $insert = OrderRow::create([
            'order_id'    => (int)$cart_id,
            'product_1c'  => $storages->code_1c_items_remains,
            'store'       => $storages->name_storage,
            'id_1c_store' => $storages->code_1c_storage,
            'size'        => $storages->name_characteristic_size_value,
            'id_1c_size'  => $storages->code_1c_characteristic_size_value,
            'color'       => $storages->name_characteristic_color_value,
            'id_1c_color' => $storages-> code_1c_characteristic_color_value,
            'product_name'=> $storages->name,
            'count'       => 1,
            'price'     => ($request->old_price)?$request->old_price:$product->price_value,
            'price_sum' => ($request->new_price)?$request->new_price:$product->price_value,
            'discount'  => $request->discount,
        ]);
        return $insert;
      }
      
      
      public function productInsertUnder($product, $size, $color, $cart_id, $color_id, $size1c, $request)
      {
          $insert = OrderRow::create([
              'order_id'    => (int)$cart_id,
              'product_1c'  => $product->code_1c,
              'store'       => 'For orders',
              'id_1c_store' => '5feb430b-f775-11e7-8158-00215a4648ba',
              'size'        => $size,
              'id_1c_size'  => $size1c,
              'color'       => $color,
              'id_1c_color' => $color_id,
              'product_name'=> $product->name,
              'count'       => 1,
              'price'     => (isset($request->old_price))?$request->old_price:$product->price_value,
              'price_sum' => ($request->new_price)?$request->new_price:$product->price_value,
              'discount' => $request->discount,
          ]);
        return $insert;
      }
      
      
      
      
      private function updateOrderRowComment($id,$comment){
        $update = DB::table('order_row')
                      ->where('id', '=', $id)
                      ->update([
                          'comment' => $comment,
                        ]);
        return $update;
      }


 



//    public function insertProduct($cart_id, $storages, $count)
//    {
//        $insert = OrderRow::updateOrCreate([
//            'order_id'    => $cart_id,
//            'product_1c'  => $storages->code_1c_items_remains,
//            'store'       => $storages->name_storage,
//        ],[
//            'size'   => $storages->name_characteristic_size_value,
//            'color'  => $storages->name_characteristic_color_value,
//            'count'     => $count,
//            'price'     => $storages->price_value,
//            'price_sum' => $storages->price_value * $count + 1,
//            
//        ]); 
//         
//        
//        return $insert;
//    }
    
    
    
    
    
    
    /**
     * Отримання к-сті продутка в row
     * та збільшення к-сті на 1
     * 
     * @param string $cart_id
     * @param string $pr_code_1c
     * @return int
     */
//    public function countPrRow($cart_id, $storages)
//    {
//       $sql = OrderRow::where('order_id',   '=', $cart_id)
//                      ->where('product_1c', '=', $storages->code_1c_items_remains)
//                      ->where('store', '=', $storages->name_storage)
//                      ->where('color', '=', $storages->name_characteristic_color_value)
//                      ->where('size',  '=', $storages->name_characteristic_size_value)
//                      ->first();
//        if($sql) {
//            return (int)$sql->count + 1;
//        } else {
//            return 1;
//        }
//    }
    
    
    
   
    /**
     * 
     * @param string $id
     * @return type
     */
    private function getProductByCode1C($id)
    {
          return  DB::table('products as pr')
                  ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                  ->where('pr.code_1c','=', $id)
                  ->select('pr.name','pp.price_value', 'pr.id', 'pr.code_1c')
                  ->first();
    }
    
    
    
     public function getUserCartAll() 
    {
        $sql = Orders::where('order_user', '=', Auth::user()->id)
                    //  ->where('id', '=', $id)
                     // ->where('order_status','=', 'cdefa9ba-ce87-11e5-8584-005056c00008')
                      ->first();
        return $sql;
        
    }
    
    
    
    public function getUserCart() 
    {
        $sql = Orders::where('order_user', '=', Auth::user()->id)
                      ->where('order_synk_1c', '=', 0)
                      ->where('order_status','=', '300fcfe2-16bd-11e7-bff6-00215a4648ba')
                      ->first();
        return $sql;
        
    }

    public function getUserCartID()
    {
        $sql = Orders::where('order_user', '=', Auth::user()->id)
            ->where('order_synk_1c', '=', 0)
           ->where('order_status','=', Orders::STATUS_NOT_CONFIRM)
            ->pluck('id')->first();
        return $sql;
    }
    
    public function getUserCartHistory() 
    {
        $sql = Orders::where('order_user',       '=',  Auth::user()->id)
                      ->where('order_status',    '!=', Orders::STATUS_NOT_CONFIRM)
                      ->orWhere('buyer_user_1c', '=',  Auth::user()->user_code_1c)
                      ->get();
                      // dd($sql);
        return $sql;
        
    }

    public function getBuyerHistory($id) 
    {
        $sql = Orders::where('order_status',    '!=', Orders::STATUS_NOT_CONFIRM)
                      ->where('buyer_user_1c',  '=',  $id)
                      ->get();
        return $sql;
        
    }

    public function getUserCartHistoryById($id) 
    {
        $sql = Orders::where('order_user', '=', $id)
                      ->where('order_status','!=', '300fcfe2-16bd-11e7-bff6-00215a4648ba')
                      ->get();
        return $sql;
        
    }

    public function getUserCartHistoryByOrderId($id)
    {
        $sql = Orders::where('id', '=', $id)
            ->where('order_status','!=', '300fcfe2-16bd-11e7-bff6-00215a4648ba')
            ->get()->first();
        return $sql;

    }
    
    public function getUserCartDetailHistory($cart_id) 
    {
        $sql = Orders::where('order_user', '=', Auth::user()->id)
                      ->where('id', '=', $cart_id)
                      ->where('order_status','!=', '300fcfe2-16bd-11e7-bff6-00215a4648ba')
                      ->first();
        return $sql;
    }

    public function getOrderSum($cart_id)
    {
        $sql = OrderRow::where('order_id', '=', $cart_id)
            ->sum('price');
        return $sql;
    }

    public function getTotalDiscount($cart_id)
    {
        $sql = OrderRow::where('order_id', '=', $cart_id)
            ->sum('price_sum');
        return $sql;
    }
    
    
     public function getUserCartOrder($order_id) 
    {
        return  Orders::where('id', '=',$order_id )->first();
    }
    
    
    
    
    
    /**
     * Витягуємо продукт з карт
     */
    
    private function IssetPrInCart($storeges, $cart_id) 
    {
        return OrderRow::where('order_id',   '=', $cart_id)
                      ->where('product_1c', '=', $storeges->code_1c_items_remains)
                     // ->where('store', '=', $storeges->name_storage)
                      ->where('color', '=', $storeges->name_characteristic_color_value)
                      ->where('size',  '=', $storeges->name_characteristic_size_value)
                      ->first();
    }
    
    
    
    private function countRemains($storages)
    {
        return DB::table('remains')
                ->where('code_1c_items_remains', '=', $storages->code_1c_items_remains)
                ->where('name_storage', '=', $storages->name_storage)	
                ->sum('remains');
    }
    
    
    /**
     * Отримання к-сті продутка в row
     * 
     * @param string $cart_id
     * @param object $storages
     * @return object
     */
    public function countPrRow($cart_id, $storages)
    {
        $sql = OrderRow::where('order_id',   '=', $cart_id)
                      ->where('product_1c', '=', $storages->code_1c_items_remains)
                      ->where('store', '=', $storages->name_storage)
                      ->count();
        return $sql;
        
    }
    
    
    
    public function getCartRow($br_id) 
    {
        return  OrderRow::where('id', '=', $br_id)->first();
    }
    
    public function updateCartRow($data, $product_data) 
    {
        $pr = $product_data->first();
      
        return OrderRow::where('id', '=', $data->id)->update([ 
            'product_1c'   => $pr->code_1c_prod,
            'price'        => $pr->price_value,
            'price_sum'    => $pr->price_value,
            'product_name' => $pr->name_items,
            'color'        => $pr->value,
            'id_1c_color'  => $pr->code_1c_characteristic_color_value,
            'size'         => $pr->name_characteristic_size_value,
            'id_1c_size'   => $pr->code_1c_characteristic_size_value,
            'store'        => $pr->name_storage,
            'id_1c_store'  => $pr->code_1c_storage
        ]);
    }
    
    
    public function insertCartRow($product_data, $order_id)
    {
        $pr = $product_data->first();
        $order = new OrderRow();
        return $order->create([ 
            'order_id'     => $order_id,
            'product_1c'   => $pr->code_1c_prod,
            'price'        => $pr->price_value,
            'price_sum'    => $pr->price_value,
            'product_name' => $pr->name_items,
            'color'        => $pr->value,
            'id_1c_color'  => $pr->code_1c_characteristic_color_value,
            'size'         => $pr->name_characteristic_size_value,
            'id_1c_size'   => $pr->code_1c_characteristic_size_value,
            'store'        => $pr->name_storage,
            'id_1c_store'  => $pr->code_1c_storage
        ]);
    }
    
    
    
}

