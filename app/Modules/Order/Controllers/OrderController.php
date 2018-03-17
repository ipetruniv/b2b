<?php

namespace App\Modules\Order\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Order\Traits\OrderTrait;
use App\Modules\Order\Models\Orders;
use App\Models\CharacteristicValue;
use Validator;
use Auth;
use DB;
use Session;
use App;
use App\Traits\Common;

class OrderController extends Controller
{
    
    use OrderTrait;
    use Common;
 //   use CatalogTrait; 

    public function __construct()
    {
        $this->middleware('auth');

        $buyer = Session::get('buyer');
        Orders::where('order_user',Auth::user()->id)
              ->where('order_status',Orders::STATUS_NOT_CONFIRM)
              ->update(['buyer_user_1c'=>$buyer->user_code_1c]);

    }
    
    
    /**
     * Добавлення товару в корзину
     * 
     * @param Request $request
     * @param  $prod_id string
     * @return object
     */
   
    
    public function AddInCart(Request $request) 
    {   

             
        if($storages = $this->getStorageProduct($request )) {     // перевырка скдаду
            $cart = $this->cartPush();                                        //створення корзини або редагування
//            if($cart::STATUS_RESERVATION AND $storages->is_last()){
//                $cartCount = $this->getUserCart();
//                $count =  $cartCount->getOrderRows->sum('count');
//                return response()->json(['count'=>$count]);
//
//            }
            if($cart) {
                $countRow = $this->countPrRow($cart->id,$storages); //рахуємо к-сть в корзині 
                $productCart = $this->IssetPrInCart($storages, $cart->id);  //перевірка чи є продукт
                $cartData = $this->productInsert($storages, $cart->id, $request); //вставляємо
                
                if($cartData){
                    $cartCount = $this->getUserCart(); 
                    $count =  $cartCount->getOrderRows->sum('count');
                    return response()->json(['count'=>$count]); 
                } else {
                    return response()->json(['error'=>'False data passed']); 
                }
            }  
        } else {
          
          $cart = $this->cartPush(); 
           if($cart) {

               $product = $this-> getProductByCode1C($request->product);
               
                if($request->size == 'ind'){
                    $request->color_id = CharacteristicValue::where('value', '=',$request->color)->value('code_1c');
                    $request->size1c = '381e2545-269f-11e7-ba21-00215a4648ba';
                    $request->size = 'Ind';
                    $request->old_price = $product->price_value;
                    $request->new_price = ceil ($product->price_value + ($product->price_value/100*$request->discount));
                    
                    $comment=$this->individualSize ($request); //проверяем и объеденяем будующий комментарий
                    if(is_object($comment)){
                            return response()->json(['error'=>$comment->messages()]);
                    }
 
                }
                else{
                    $request->size1c = CharacteristicValue::where('value', '=',$request->size)->value('code_1c');
                }                
                $cartData = $this->productInsertUnder($product,$request->size,$request->color, $cart->id, $request->color_id, $request->size1c,$request);//вставляємо
                
                if($cartData){
                    if($request->size == 'Ind')
                        $commentOrderRow = $this->updateOrderRowComment($cartData->id,$comment);//записываем индивидуальный размер в комментарий
                    $cartCount = $this->getUserCart(); 
                    $count =  $cartCount->getOrderRows->sum('count');
                    return response()->json(['count'=>$count]); 
                } else {
                    return response()->json(['error'=>'False data passed']); 
                }
            } 
        }
                
    }
    
    public function individualSize(Request $request) {
        $validator = Validator::make($request->all(),[
             'breast_heigh'     =>'required|numeric|between:5,50',
             'shoulder_width'   =>'required|numeric|between:20,100',
             'back_width'       =>'required|numeric|between:20,60',
             'shirina_pílochki' =>'required|numeric|between:20,60',
             'breast_volume'    =>'required|numeric|between:50,150',
             'waist'            =>'required|numeric|between:50,150',
             'thigh_size'       =>'required|numeric|between:50,150',
             'length_of_sleeves'=>'required|numeric|between:1,75',
             'girth_of_the_forearm'              =>'required|numeric|between:10,60',
             'length_of_the_loop_from_the_waist' =>'required|numeric|between:150,250',
             'from_waist_to_floor'               =>'required|numeric|between:100,150',
             'length_of_the_product_along_the_side_seam' =>'required|numeric|between:100,150',
             'height_on_heels'  =>'required|numeric|between:100,250',
        ]);
        
        if(!$validator->fails()){
        $comment = 'Breast Heigh = '    .$request->breast_heigh.
                   '  Shoulder Width = '.$request->shoulder_width.
                   '  Back width = '    .$request->back_width.
                   '  Shirina pílochki = ' .$request->shirina_pílochki.
                   '  Breast volume = '    .$request->breast_volume.
                   '  Waist = '            .$request->waist.
                   '  Thigh size = '       .$request->thigh_size.
                   '  Length of sleeves = '.$request->length_of_sleeves.
                   '  Girth of the forearm = '             .$request->girth_of_the_forearm.
                   '  Length of the loop from the waist = '.$request->length_of_the_loop_from_the_waist.
                   '  From waist to floor = '              .$request->from_waist_to_floor.
                   '  Length of the product along the side seam = '.$request->length_of_the_product_along_the_side_seam.
                   '  Height on heels = '                  .$request->height_on_heels;
            return $comment;
        }else return $validator;
    }
    
    
    /**
     * Обработчик заказа
     * @param Request $request
     */
    public function Order(Request $request) 
    { 
        
        
     // dd($request->all());
        $validator = Validator::make($request->all(),[
             'date'            => 'required',
             'buyer'           => 'required|exists:users,user_code_1c',
             'order'           => 'required|exists:orders,id',
             'person'          => 'required',
             // 'post_build'    => 'required',
             // 'post_street'   => 'required',
             // 'post_city'     => 'required',
             // 'post_post_code'=> 'required',
             // 'post_country'  => 'required',
             // 'delivery_address'=> 'required',
             'cart_company'    => ($request->person == 'legal')    ? 'required' : '',
             'vat'             => ($request->person == 'legal')    ? 'required' : '',
             'name'            => ($request->person == 'physical') ? 'required' : '',
             'surname'         => ($request->person == 'physical') ? 'required' : '',
             'order_phone'     => ($request->person == 'legal')    ? 'required' : '',
             'order_email'     => ($request->person == 'physical') ? 'required' : '',
             'phone_company'   => ($request->person == 'legal')    ? 'required' : '',
             'email_company'   => ($request->person == 'legal')    ? 'required' : '',
        ]);

//        $validator->sometimes('agent','required|exists:users,user_code_1c', function($input){
//           return strlen($input->agent)>0;    
//        });
       
        
        if($validator->fails()) {
          //dd($validator);
            return redirect(App::getLocale().'/cart')->withErrors($validator)->withInput(); 
        }
        
        if(!$cart = $this->getUserCartOrder($request->order)) {
            return redirect(App::getLocale().'/cart')->with('status','NOT_FOUND_USER_CART');
        } 

       // dd($request->autocomplete);

        $update = $cart->update([
              'order_status' => 'cdefa9ba-ce87-11e5-8584-005056c00008', //резервація
              'desirable_delivery' => date('Y-m-d', strtotime($request->date)),
              'buyer_user_1c'      => $request->buyer,
              'order_synk_1c'      => 0,
              'agent_id'           => $request->agent,
              'delivery_address'   => $request->autocomplete,
              'person'             => ($request->person == 'legal')? 2 : 1,
              'order_post_code'    => (isset($request->post_post_code))   ? $request->post_post_code    : '',
              'order_build'        => (isset($request->post_build))   ? $request->post_build    : '',
              'order_street'       => (isset($request->post_street)) ? $request->post_street  : '',
              'order_city'         => (isset($request->post_city))   ? $request->post_city    : '',
//              'order_region'       => (isset($request->region)) ? $request->region  : '',
              'order_country'      => (isset($request->post_country))? $request->post_country : '',
              'order_company'      => (isset($request->cart_company))? $request->cart_company : '',
              'order_vat'          => (isset($request->vat))? $request->vat : '',
              'order_name'         => (isset($request->name))? $request->name : '',
              'order_surname'      => (isset($request->surname))? $request->surname : '',
              'order_phone'        => (isset($request->order_phone))  ? $request->order_phone  : '',
              'order_email'        => (isset($request->order_email))  ? $request->order_email   : '',
              'order_comment'      => (isset($request->order_comment))  ? trim($request->order_comment)   : '',
              'delivery_comment'   => (isset($request->comment))        ? trim($request->comment)   : '',
          ]);
        $buyer_update = DB::table('users')->where('id', '=', $request->buyer_id)->update([
            'company' => $request->cart_company,
            'vat' => $request->vat,
            'phone_company' => $request->phone_company,
            'email_company' => $request->email_company,
        ]);
       
        if($update) {

            $data['email'] = Auth::user()->email;
            $data['theme'] = __('email.orderCreateTheme');
            $data['text']  = __('email.orderCreateText');
            $this->SendMail($data);
            return view('Order::orderSuccessful');
            
        } else {
            return redirect(App::getLocale().'/cart')->with('status','DONT_UPDATE_CART_STATUS');
        }
 
    }
    
//    public function SendMail($order,$user)
//    {
//        $headers = "MIME-Version: 1.0\r\n";
//        $headers .= "Content-type: text/html; charset=utf-8\r\n";
//        $headers .= "From: " . ' MonicaLoretti ' . " <" . ' MonicaLoretti ' . ">\r\n";
//        
//        $emails[] = $user->email;
//        if($user->agent_id)
//            $agent_email = DB::table('users')->where('user_code_1c','=',$user->agent_id)->value('email');
//            if($agent_email)
//                $emails[] = $agent_email;
//            
//        if($user->diller_id)
//            $diller_email = DB::table('users')->where('user_code_1c','=',$user->diller_id)->value('email');
//            if($diller_email)
//                $emails[] = $diller_email;
//            
//        foreach ($emails as $email){
//            $link  = 'http://dev.monicaloretti.softwest.cf/en/cabinet/history/detail/'.$order;
//            $text  = view('email_tpl.success_order')->with('link', $link);
//            mail( $email, 'Order success on site MonicaLoretti!', $text, $headers ); 
//        }
//    }
}

