<?php

namespace App\Modules\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Order\Traits\OrderTrait;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Modules\Catalog\Traits\CatalogTrait;
use App\Modules\Order\Models\OrderRow;
use App\Modules\Order\Models\Orders;
use App\Models\User;
use App\Models\Products;
use Validator;
use Auth;
use DB;

class CartController extends Controller
{
    
    use OrderTrait;
    use UserTrait;
    use CatalogTrait;

    public $users = '';
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /**
     * Вивід корзини
     * 
     * @return object
     */
    
    public function CartList() 
    {   
//        $cart = $this->getUserCart();
        $order = new OrderRow();
//        dd($order->getOrderBuyer("f5e4d108-b14a-11e6-959c-7824af37f18c"));
        $user = $this->getUser(Auth::user()->id);

//        dd($user);
        $method_price = '';
        $payment_type = '';

        $userUser = $this->userIs();

        $cart_id = $this->getUserCartID();
        
        $cart_user = Orders::where('id', '=', $cart_id)->pluck('buyer_user_1c')->first();

        $cart = $this->getUserCart();


        if(!$cart) {
          $cart = new Orders;
          $cart->order_user    = Auth::user()->id;
          $cart->user_1c_id    = Auth::user()->user_code_1c;
          $cart->order_synk_1c = '0';
          $cart->order_status  = '300fcfe2-16bd-11e7-bff6-00215a4648ba';
          $cart->buyer_user_1c = User::find(Auth::user()->id)->getFirstChild();
          $cart->save();
          $cart_user = Orders::where('id', '=', $cart->id)->pluck('buyer_user_1c')->first();
        }


        if ($cart_user){

            $payment_type = $this->getUserPeimentWithoutAgent($cart_user);
            $method_price = $this->getPaymentUserMethod($cart_user);

        }

        $users_data = $this->switcType($userUser);

        if($userUser == 'Diller') {
            $this->users =  $this->getUserDiller();
        } 
        if($userUser == 'Bayer') {
            $this->users =  $this->getUserInfo();
        } 
         if($userUser == 'Agent') {
            $this->users =  $this->getUserAgent();
        } 

        $userCartRow = $cart->getOrderRows;

        $order_id = $this->getUserCartID();
        $totalSum = $this->getOrderSum($cart->id);
        $totalDiscount = $this->getTotalDiscount($cart->id);

        foreach ($userCartRow as $CartRow){
            $AllSizes = $this->getSizeUnder($CartRow->product_1c);
            $AllColors = $this->underOrder($CartRow->product_1c);
            
            $CartRow->AllSizes = $AllSizes->pluck('value','code_1c');
            $CartRow->AllColors = $AllColors->pluck('value','code_1c');
//            dd($CartRow);
        }

        return view('Order::cartList')->with([
            'cart'          => $cart,
            'userCartRow'   => $userCartRow,
            'users_data'    => $users_data,
            'users'         => $this->users,
            'type'          => $userUser,
            'cart_user'     => $cart_user,
            'totalSum'      => $totalSum,
            'totalDiscount' => $totalDiscount,
            'payment_type'  => $payment_type,
            'method_price'  => $method_price,
            'user'          => $user,
            'buyer'         => ($cart_user)?User::where('user_code_1c',$cart_user)->first():$user, 
        ]);
    }
    
    
    
    
    
    /**
     * 
     * @param Request $request
     * @return object
     */
    public function GetBuyers(Request $request) 
    {
        if($request->agent == '0') {
              $userUser = $this->userIs();
          if($userUser == 'Diller') {
              $users =  $this->getUserDiller();
              return response()->json(['ok'=>$users]); 
          }
        else {
            return response()->json(['error'=>'Agent not found']);
        }
       }
      
      
        if($checkAgent = $this->checkAgent($request->agent)) {
            $buyers = $this->getAgentuser($request->agent);   
            return response()->json(['ok'=>$buyers]); 
        } else {
            return response()->json(['error'=>'Agent not found']);
        }
    }
    
    public function GetPaimentType(Request $request) 
    {

        $agent = '';
        $method_payment = '';
        $cart_id = $this->getUserCartID();
        DB::table('orders')->where('id', '=', $cart_id)->update([
            'buyer_user_1c' => $request->user,
        ]);

        if($request->agent == '0' && $request->user) {
           $data  = $this->getUserPeimentWithoutAgent($request->user);
           $agent = $this->userAgent($data);
            $method_payment = $this->getPaymentUserMethod($request->user);
        } else {
            $data = $this->getUserPeiment($request->agent, $request->user);
        }

        $user = User::where('user_code_1c',$request->user)->first();
        $type_price = $user->type_price;

        $priceArr = [];

        $cartItems = OrderRow::where('order_id',$cart_id)->get();
        if(!empty($cartItems))
          foreach ($cartItems as $item) {

              $userprice = DB::table('product_price')->where('code_1c_items',$item->product_1c)->where('code_1c_price_type',$user->price_type)->pluck('price_value')->first();
              // dd($userprice);
              // print_r($user->price_type);exit;


              $discount = $this->setDiscount([
                  'user_id' => $request->user,
                  'product' => $item->product_1c,
                  'color'   => $item->id_1c_color,
                  'size'    => $item->id_1c_size,
              ],$item->id);

              $prod_price = DB::table('product_price')
                        ->where('code_1c_items', '=', $item->product_1c)
                        ->where('code_1c_price_type','=',$type_price)->first();

              $new_price = $prod_price->price_value;

              DB::table('order_row')->where('id', '=', $item->id)->update([
                  // 'price_sum' => $total,
                  'price' => $new_price
              ]);
              $totalDiscount = $this->getTotalDiscount($cart_id);
              $totalSum = $this->getOrderSum($cart_id);
              $priceArr[$item->id]=['discount1'=>$discount,'price'=>$prod_price->price_value,'total'=>OrderRow::find($item->id)->price_sum];
              $total = ['total_discount'=>$totalDiscount, 'total_sum'=>$totalSum-$totalDiscount];
          }

        if( count($data)>0 ) {
            return response()->json(['ok'=>$data,'prices'=>$priceArr, 'agent'=>$agent, 'method_payment'=>$method_payment, 'total'=>$total??0 ]);
        } else {
            return response()->json(['error'=>'not found user payment or agent']);
        }
    }  
    
    
    /*
     * Вибірка всіх продуктів з каталогу
     * 
     * @return object
     */
    public function getAllProduct(Request $request)
    {

        if($this->userIs() == 'Bayer' && $product = $this->getProductCatalog()) {
            $product = $product->toArray();
            sort($product);
            $product = collect($product);
            return response()->json(['ok'=>$product]);
        }
        if( $product = $this->getProductCatalog()) {
            $product = $product->toArray();
            sort($product);
            $product = collect($product);
            return response()->json(['ok'=>$product]);
        }



        if(!$data = $this->getUserPeiment($request->agent, $request->user)) {
            return response()->json(['error'=>'В юзера не має Peiment metod']);
        }

       if($product = $this->getProductCatalog($data->type_price)) {
            return response()->json(['ok'=>$product]);
       } else {
            return response()->json(['error'=>'This user has no products available']);
       }

    }
    

    public function DeleteProduct($lang, $id) 
    {

      $row = DB::table('order_row')->where('id',$id)->delete();

      if(!$row)
        return response()->json( [ 'error' =>'Not found Order' ]);
      else 
        return response()->json( [ 'success' =>'Delete product' ]);

        // if(!$cart = $this->getUserCart() ) {
        //    return response()->json( [ 'error' =>'Not found Order' ]);
        // }
        
        // $userCartRow = $cart->getOrderRows; 
        
        // if($rezult = $userCartRow->where('id','=',$id)->first()) {
        //     if( $rezult->delete() ) {
        //         return response()->json(['ok'=>'Delete product']);
        //     } else {
        //         return response()->json(['error'=>'DELETE FAIL']);
        //     }
        // } else {
        //     return response()->json(['error'=>'DATA FAIL']);
        // }

     }
    
     
     
      public function GetProductColorSize(Request $request) 
      {
          if(!$user = $this->getUserByCode($request->user)) {
            return response()->json(['error'=>'USER_FEIL']);
          }
          if($product = $this->underOrder($request->product,  $user->type_price)) {
            
          //  $pr = $product->select('code_1c_characteristic_size_value','name_characteristic_size_value','price_value')->distinct()->get();
            //$color = $product->select('value','code_1c_characteristic','price_value')->distinct()->get();

              return response()->json([
                  'ok'     =>  $this->getSizeUnder($request->product,  $user->type_price),
                  'colors' => $product
              ]);
          }
          
      }
      
      
      
      public function GetProductPrice(Request $request) 
      {
          if(!$user = $this->getUserByCode($request->user)) {
            return response()->json(['error'=>'USER_FEIL']);
          }

          if($storages = $this->getStoragesByIdOrd($request,$user->type_price )) { // перевырка скдаду
              $cart = $this->getUserCartOrder($request->order_id);
              $product = $this-> getProductByCode1C($request->product);
              if($cart) {
                  if($request->br_id !== 'empty-column') {
                     $cartData = $this->productUpdate($storages, $request->br_id, $cart->id); //вставляємо
                  } else {
                    $cartData = $this->productInsert($storages, $cart->id, $request,$product); //вставляємо
                  }

                 $this->setDiscount([
                     'user_id' => $request->user,
                     'product' => $request->product,
                     'color'   => $request->color,
                     'size'    => $request->size,
                 ],($request->br_id !=='empty-column')?$request->br_id:$cartData->id);
                  if($cartData){
                      return response()->json([ 'ok'=> $cartData, 'color'=>$storages->code_1c_characteristic_color_value]);
                  } else {
                        return response()->json(['error'=>'False data passed']);
                  }
              }  else {

              }
           } else {

//              $cart = $this->getUserCartOrder($request->order_id);
              $product = $this-> getProductByCode1C($request->product);
              $color = $this->getAttrPr($request->color);
              $size = $this->getAttrPr($request->size);
              $price  = $this->getProdPrice($request->product,$user->type_price);

              $data = [
                  'product_1c'   => $product->code_1c,
                  'store'        => 'For orders',
                  'id_1c_store'  => '5feb430b-f775-11e7-8158-00215a4648ba',
                  'size'         => $size,
                  'id_1c_size'   => $request->size,
                  'color'        => $color,
                  'product_name' => $product->name,
                  'price'        => $price->price_value,
                  'price_sum'    => $price->price_value,
                  'count'        =>1
              ];

              if(isset($request->comm) AND $request->size == '381e2545-269f-11e7-ba21-00215a4648ba')
                  $data['comment'] = $request->comm;
              else
                  $data['comment'] = '';

              if($request->br_id != 'empty-column') {
                  $data['product_name'] = $product->name;
                  $cartData = $this->updateCartRow($request->br_id, $data);
              }else{
                  $data['order_id']    = (int)$request->order_id;
                  $data['id_1c_color'] = $request->color;
                  $cartData = OrderRow::create($data);
              }

              $discount = $this->setDiscount([
                  'user_id' => $request->user,
                  'product' => $product->code_1c,
                  'color'   => $request->color,
                  'size'    => $request->size,
              ],($request->br_id !=='empty-column')?$request->br_id:$cartData->id);

             if($cartData){
                  return response()->json([ 'ok'=> $cartData]);
              } else {
                  return response()->json(['error'=>'False data passed']);
              }
          }
      }

      public function getProdPrice($product,$type_price){

            $result = DB::table('product_price')
              ->where('code_1c_price_type','=',$type_price)
              ->where('code_1c_items','=',$product)->first();
            return $result;
      }

      protected function updateCartRow($id,$data){

        $cartRow = OrderRow::where('id','=',$id)->update($data);
        return $cartRow;
      }
      
      public function productInsertUnderUpdate($product, $size, $color, $or_id, $color_id,$size1c, $br_id)
      {
          $update = OrderRow::where('id', '=', $br_id)->where('order_id', '=', $or_id)->update([
           //   'order_id'    => (int)$cart_id,
              'product_1c'  => $product->code_1c,
              'store'       => 'For orders',
              'id_1c_store' => '5feb430b-f775-11e7-8158-00215a4648ba',
              'size'        => $size,
              'id_1c_size'  => $size1c,
              'color'       => $color,
              'id_1c_color' => $color_id,
              'product_name'=> $product->name,
              'count'       => 1,
              'price'     => $product->price_value,
//              'price_sum' => $product->price_value,
          ]);
        return $update;
      }
      
      
      
      
      private function productUpdate($storages, $br_id, $or_id) 
      { 
        $update = OrderRow::where('id', '=', $br_id)->where('order_id', '=', $or_id)->update([
           // 'order_id'    => (int)$cart_id,
            'product_1c'  => $storages->code_1c_items_remains,
            'store'       => $storages->name_storage,
            'id_1c_store' => $storages->code_1c_storage,
            'size'        => $storages->name_characteristic_size_value,
            'id_1c_size'  => $storages->code_1c_characteristic_size_value,
            'color'       => $storages->name_characteristic_color_value,
            'id_1c_color' => $storages-> code_1c_characteristic_color_value,
            'product_name'=> $storages->name,
            'count'       => 1,
            'price'     => $storages->price_value,
            'price_sum' => $storages->price_value,
        ]);
        return $update;
      }
      
      /*
    * Отримання даних по продукту на складі
    * 
    * @param string $storeges_id
    * return object
    */
    private function getStoragesByIdOrd($request, $user_pr_type) 
    {
        return DB::table('remains')
                ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
                ->leftJoin('products','remains.code_1c_items_remains', '=', 'products.code_1c' )
                ->where('pp.code_1c_price_type', '=',$user_pr_type ?? Auth::user()->type_price)
                ->where('remains.code_1c_items_remains', '=', $request->product)
              //  ->where('remains.code_1c_storage', '=',$request->storage)
                ->where('remains.code_1c_characteristic_color_value', '=', $request->color)
                ->where('remains.code_1c_characteristic_size_value', '=', $request->size)
                ->first();
    }
      
      
      
    public function insertCartRowProd($product_data, $order_id)
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
      
      
      
      
      
      public function GetProductByColor(Request $request)
      {
        
          if(!$user = $this->getUserByCode($request->user)) {
            return response()->json(['error'=>'USER_FEIL']);
          }
          
          if($product = $this->getFindProductSize($request->product, $user->type_price, $request->color)) {
              return response()->json([
                  'ok'=>$product->get()
              ]);
          }
          
      }
      public function updateComment(Request $request) {
        $validation=Validator::make($request->all(), [
            'comment' => 'string|max:255',
            ]);
        if(!$validation->fails()){
          if($update=$this->updateOrderRowComment($request->id,$request->comment)){
            return response()->json(['ok']);
          }
        }
        return response()->json(['error']);
      }

      public function setCustomSize(Request $request){

        $id = $request->customSize['id'];
        $comment = str_replace('_',' ',$request->data);
        $comment = str_replace('&',' ',$comment);

//          $result = OrderRow::where('id','=',$id)->update([
//              'comment'=>$comment
//          ]);

          return response()->json(['comment'=>$comment]);

//          if($result)
//              return response()->json(['status'=>'ok']);
//          else
//              return response()->json(['status'=>'error']);
      }
      
      
    /**
     * Дістає залишки товарів
     * 
     * @param string $product_id
     * @return object
     */
    private function getProductRemainsCart($product_id,$user_price_type = null, $color = null, $size =null)
    {
   
            $rezult = DB::table('remains')
                  ->leftjoin('size_color_access as sca','remains.code_1c_characteristic_color_value','=', 'sca.code_1c_characteristic_value')
                  ->leftjoin('characteristic_value as ch','remains.code_1c_characteristic_color_value','=', 'ch.code_1c')
                  ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', $user_price_type ?? Auth::user()->type_price)
                  ->where('remains.code_1c_items_remains', '=', $product_id)
                  ->where('pp.code_1c_items','=',$product_id)
                  ->where('sca.not_enabled', '=', 0)
                  ->where('sca.code_1c_prod', '=',$product_id)
                  ->where('remains', '>', 0)
                  ->orderBy('ch.sort_color', 'asc')
                  ->orderBy('remains.name_characteristic_size_value', 'asc')
                  ->distinct();
                  //->get();     
                  if($color !== null) {
                    $rezult->where('sca.code_1c_characteristic_color_value','=',$color);
                  }
                  if($size !== null) {
                    $rezult->where('sca.code_1c_characteristic_size_value','=',$size);
                  }
                  return $rezult;
    } 
    
    
    public function getFindProductSize($product_id,$user_price_type = null, $color = null, $size =null) 
    {
      dd($color);
        return $rezult = DB::table('size_color_access as sca')
                 ->leftjoin('characteristic_value as ch','sca.code_1c_characteristic_value','=', 'ch.code_1c')
                 ->leftJoin('product_price as pp','sca.code_1c_prod', '=', 'pp.code_1c_items')
                 ->where('pp.code_1c_price_type', '=', $user_price_type ?? Auth::user()->type_price)
                 ->where('sca.code_1c_prod','=',$product_id)
                 ->where('sca.not_enabled', '=', 0)  
               //  ->where('sca.code_1c_characteristic', '=', 'ee4e42dc-ce8b-11e5-8584-005056c00008')
                ->orderBy('ch.value', 'asc')
                ->distinct();
                if($color !== null) {
                  $rezult->where('code_1c_characteristic_value','=',$color);
                  $rezult->where('sca.code_1c_characteristic', '=', 'ee4e42da-ce8b-11e5-8584-005056c00008');
                }
                if($size !== null) {
                  $rezult->where('code_1c_characteristic_value','=',$size);
                  $rezult->where('sca.code_1c_characteristic', '=', 'ee4e42dc-ce8b-11e5-8584-005056c00008');
                }
                  
                  
        return $rezult;
    }
    
    
    
    public function getAttrPr($code_attr)
    {
        return DB::table('characteristic_value')->where('code_1c', '=', $code_attr)->pluck('value')->first();
    }


    public function setDiscount($attributes,$id=null){
        if(isset($attributes['product']))
            $attributes = $this->getCollection($attributes);

        $i   = 0;
        $sql = 'SELECT * FROM action  WHERE active = 1 AND  id IN(';
        foreach($attributes as $key => $item){
            if($i)
              $sql.= " OR {$key} = '{$item}'";
            else
              $sql.= "SELECT action_id FROM action_value where {$key} = '{$item}'";
            $i++;
        }

        $sql .= ')';

        $discounts = DB::select($sql);
        $us = DB::table('users')->where('user_code_1c','=',$attributes['user_id'])->first();
        $pr = DB::table('product_price')
                ->where('code_1c_items','=',$attributes['product'])
                ->where('code_1c_price_type','=',$us->type_price)->first();

        if(!empty($discounts)){
            $sum = 0;
            $arrPlus  = [];
            $arrMinus = [];
            foreach ($discounts as $item){
                if($item->sign == 1){
                        $sum = $sum + $item->sum;
                }else{
                    if((int)$item->sum > 0)
                        $arrPlus[]  = $item->sum;
                    else
                        $arrMinus[] = $item->sum;
                }
            }

            $discount = [];
            if(!empty($arrPlus))
                $discount[] = min($arrPlus);

            if(!empty($arrMinus))
                $discount[] = min($arrMinus);

            $discount = (min($discount) < $sum)?min($discount): $sum ;
            $cartRow = OrderRow::find($id);

            $price_sum = ceil($pr->price_value + ($pr->price_value * $discount /100));
                $this->updateCartRow($id,['discount'=>$discount,'price_sum'=>$price_sum]);
                return ['discount'=>$discount,'price_sum'=>$price_sum,'cartRow'=>$cartRow];

        }else{
          $this->updateCartRow($id,['price_sum'=>$pr->price_value]);
        }
    }

    public function getCollection($data){

        $product = Products::where('code_1c','=',$data['product'])->first();
        $group = DB::table('items_group')->where('items_group_code_1c','=',$product->code_1c_items_group)->first();
        if($group->code_1c_parent != "00000000-0000-0000-0000-000000000000")
            $brand =  DB::table('items_group')->where('items_group_code_1c','=',$group->code_1c_parent)->first();

        if(isset($group->items_group_code_1c))
            $data['collection'] = $group->items_group_code_1c;

        if(isset($brand->items_group_code_1c))
            $data['brend'] = $brand->items_group_code_1c;

        return $data;
    }
}

