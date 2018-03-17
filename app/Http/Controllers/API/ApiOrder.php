<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrdersStatus;
use App\Modules\Order\Traits\OrderTrait;
use App\Modules\Order\Models\Orders;
use App\Modules\Order\Models\OrderRow;
use Validator;
use DB;
use App\Models\User;
use App\Traits\Common;



class ApiOrder extends Controller
{
    use Common;
  
    /**
     * Список замовлень
     * @return xml
     */
    public function OrderList()
    {
        $orders = Orders::where('order_synk_1c', '=', 0)
                         ->whereNotIn('order_status',['300fcfe2-16bd-11e7-bff6-00215a4648ba']) //статус резервації
                         ->whereNotNull('buyer_user_1c')
                         ->get();
       
        //dd($orders);
        if ($orders) {
            $xml_orders = new \SimpleXMLElement( "<?xml version=\"1.0\"?><orders></orders>" );
            $data_pr = [];
            $orderTotal = 0;
            foreach ( $orders as $row  )
            {
          //  dd($row->getTypeUserPrice->type_price);
              
              foreach($row->getOrderRows as $v) {
               $orderTotal += $v->price_sum;
               $data_pr[]  =  [
                      'product_web_id' => $v->id,
                      'prod_1c'     => $v->product_1c,
                      'price'       => $v->price,
                      'price_sum'   => $v->price_sum,
                      'discount_rate'=>($v->discount * -1),
                      'color'       => $v->color,
                      'id_1c_color' => $v->id_1c_color,
                      'size'        => $v->size,
                      'id_1c_size'  => $v->id_1c_size,
                      'store'       => $v->store,
                      'id_1c_store' => $v->id_1c_store,
                      'comment'     => $v->comment,

                      
                  ] ;
              }
              
              $this -> prepareXml( [ 'data' => [
                  'order_code_1c'      => $row->order_code_1c,
                  'order_web_id'       => $row->id,
                  'user_name'         => $row->getTypeUserPrice->name,
                  'user_type_price'    =>$row->getTypeUserPrice->type_price,
                  'order_number_1c'    => $row->order_number_1c,
                  'order_sum'          => $orderTotal,
                  'order_status'       => $row->order_status, 
                  'desirable_delivery' => $row->desirable_delivery->format('d-m-Y H:i:s'),
                  'payment_method'     => User::where('user_code_1c','=',$row->buyer_user_1c)->first()->type_pay,
                  'person'             => $row->person,
                  'order_comment'      => $row->order_comment,
                  'address_user_pos_comment'   => $row->delivery_comment,
                  'address_user_pos'   => $row->delivery_address,
                  'user_1c_id'         => $row->buyer_user_1c,
//                  'order_company'      => $row->order_company,
//                  'order_region'       => $row->order_region,
//                  'order_city'         => $row->order_city,
//                  'order_street'       => $row->order_street,
//                  'order_build'        => $row->order_build,
//                  'order_post_code'    => $row->order_post_code,
//                  'order_email'        => $row->order_email,
                  'created_at'         => $row->created_at->format('d-m-Y H:i:s'),
                  'products'           => $data_pr,
                ] ], $xml_orders );
              unset($data_pr);
            }
            header( 'Content-type: text/xml' );
            exit( $xml_orders -> asXML() );
        }
    } 
    
    
  private function prepareXml ($order, &$xml_order)
  {
      foreach ( $order as $key => $value ) {
          if ( is_array( $value ) ) {
              if ( ! is_numeric( $key ) ) {
                  if ( $key == 'SERIALIZE' )
                    continue;

                  $subnode = $xml_order -> addChild( "{$key}" );
                  self::prepareXml( $value, $subnode );
              }
              else {
                  $subnode = $xml_order -> addChild( "item{$key}" );
                  self::prepareXml( $value, $subnode );
              }
          } else
              $xml_order -> addChild( $key, $value );
      }
  }

    /**
     * Статуси замовлення
     * 
     * @param Request $request
     * @return object
     */
      public function addOrderStatus() 
      { 
          if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
//             $status = new OrdersStatus();
            foreach( $rezult as $row ) {
                $check = $this->ValidPostData($row);
                if($check == false) {
                    $err[] = [
                        'WARNING' => "Пусті поля не приймаю {$row}",
                    ];
                   continue;
                }


                $OrdersSt = OrdersStatus::updateOrCreate(
                    ['code_1c' => $row->code_1c],
                    ['code_1c' =>  $row->code_1c,'name' => $row->name]);
            }
            if($rezult) {
                return response()->json(['status' =>'OK'], 200);
            } else {
                return response()->json(['errors' => 'ERROR_SQL'], 422);
            }
          } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
          }
         
      }
 
      
      
      public function UpdateOrders() 
      {
          if( isset($_POST['xml']) ) {   
            $rezult = simplexml_load_string($_POST['xml']);
            if(!$rezult) {
                return response()->json(['status' => 'OK'], 422);
            }

              foreach( $rezult as $row ) {
                  $check = $this->ValidPostDataUpdate($row);
                  if($check == false) {
                      $err[] = [
                        'WARNING' => "Пусті поля не приймаю {$row}",
                    ];
                      continue;
                  }


                  // print_r($order->desirable_delivery);exit;
                  $update = $this->OrdersUpdate($row);

                  $updateProd = $this->DataProd($row->products, $row->order_web_id);

                  if($update || $updateProd) {

                    $order = Orders::where('id',$row->order_web_id)->first();
                    $user  = User::find($order->order_user);
                    $data['email'] = $user->email;
                    $data['theme'] = __('email.editOrderTheme');
                    $data['text']  = __('email.editOrderText',['data'=>$order->desirable_delivery,'order'=>$order->order_number_1c]);
                    $this->SendMail($data);

                    return response()->json(['status' =>'OK'], 200);
                } else {
                    return response()->json(['errors' => 'NOT_UPDATE'], 422);
                }
            }
            
          } else {
            return response()->json(['errors' => 'ERROR_POST'],422);
          }
      }
      
      
      public function OrdersUpdate($data) 
      {

        return  DB::table('orders')->where('id','=',$data->order_web_id)->update([
                  'order_code_1c'   => $data->order_code_1c,
                  'order_number_1c' => $data->order_number_1c,
                  // 'order_sum'       => $data->order_sum,
                  'order_status'    => $data->order_status,
                  'order_comment'   => $data->order_comment,
                  'order_synk_1c'   => 1,
                ]);
      }
      
      
      public function DataProd($products, $order_web_id) 
      {
          $k = 0;
          foreach($products as $row) {
            
             foreach($row as $value) {
                $item = 'item'.$k;
                 $this->updateProd($row->$item, $order_web_id);
                  $k++;
             }

          }
          return true;
         
      }
      
      public function updateProd($product, $order_web_id) 
      {
          $order_row =  DB::table('order_row')->where('order_id','=',$order_web_id)
                          ->where('id','=',$product->product_web_id)->first();

          DB::table('order_row')->where('id','=',$product->product_web_id)->update([
                    'price'         => (!empty($product->price))? $this->price($product->price) : $order_row->price,
                    'price_sum'     => (!empty($product->price_sum))? $this->price($product->price_sum) : $order_row->price_sum,
                    'size'          => (!empty($product->price_sum))? $product->size : $order_row->size,
                    'id_1c_size'    => (!empty($product->id_1c_size))? $product->id_1c_size : $order_row->id_1c_size,
                    'color'         => (!empty($product->color))? $product->color : '',
                    'id_1c_color'   => (!empty($product->id_1c_color))? $product->id_1c_color : $order_row->id_1c_color,
                    'store'         => (!empty($product->store))? $product->store: '',
                    'id_1c_store'   => (!empty($product->id_1c_store))? $product->id_1c_store: $product->id_1c_store,
                    'comment'       => (!empty($product->comment))? $product->comment: '',
                    'consignment'   => (!empty($product->name_consignment))?$product->name_consignment:'',
                ]);
          return true;
      }
      
      
    public function price($price)
    {
      return str_replace(',', '.',$price );
    }
    public function ValidPostDataUpdate($data) 
    {
        if(isset($data->order_code_1c, $data->order_number_1c, $data->order_web_id )) { 
          return true;
        } else {
          return false;
        }
    
    }  
      
    
    public function ValidPostData($data)
    {
        if(isset($data->code_1c, $data->name )) { 
          return true;
        } else {
          return false;
        }
    
    }
      
      
   
}