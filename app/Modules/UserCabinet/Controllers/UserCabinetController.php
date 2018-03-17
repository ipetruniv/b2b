<?php

namespace App\Modules\UserCabinet\Controllers;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Modules\Order\Traits\OrderTrait;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\CharacteristicValue;
use Validator;
use Auth;
use App;
use DB;

class UserCabinetController extends Controller
{
    use UserTrait;
    use OrderTrait;

    private $agent_list = '';
    private $type       = '';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Виводимо список користувачів
     * які доступні для юзера по типу
     *
     * @return object
     */
    public function userList()
    {

        $currency_type = $this->getUserCurrency();

        $userIs = $this->userIs();

        if($userIs == 'Diller') { // якщо юзер діллер
            $users = $this->getUserType();
            $this->agent_list = $this->getAgent();
        } elseif($userIs == 'Agent') { // якщо юзер агент
            $users = $this->getUserAgent();
            $this->type = $userIs;                     
        } else {
            return redirect(App::getLocale().'/cabinet/settings');
        }
        
        return view('UserCabinet::list')->with('users', $users)
                                      ->with('type',  $this->type)
                                      ->with('currency_type', $currency_type)
                                      ->with('agent_list', $this->agent_list);
    }


    /**
     * 
     * Форма добавлення користувачів
     * 
     *  getUserCurrency() - тип валюти користувача
     *  userIs()          - тип користувача
     *  typeOfValue()     - тип значення ціни 
     *  getPeymentUserMethod - тип оплати
     * 
     * @return string
     */
    
    public function UserAddForm() 
    { 

        if(!$currency_type = $this->getUserCurrency()) {
            dd('FATAL USER');
        }
               
        $diller = Auth::user()->user_code_1c;
            
        $typOf = $this->iKostyl($this->getUserPeimentNew($diller, '1'));

        $agent_list = $this->getAgent(); 

        $type = $this->userIs();

        $pay_method = $this->iKostyl($this->getUserPeimentNew($diller, '2'));
        
        return view('UserCabinet::form-user-add')->with([
            'type'          => $type,
            'typOf'         => $typOf,   
            'currency_type' => $currency_type,
            'agent_list'    => $agent_list,
            'pay_method'   => $pay_method,
        ])->render();
        
        return $contents;

    }  
    
    
     
    /**
     * Створення користувачів 
     * типи:
     *   якщо diller:  bayer, agent
     *   якщо agent: bayer
     *   
     * @param Request $request
     * @return object
     */

    public function create(Request $request)
    {
         $typeUser = $this->userIs();
        // перевірка користувача на право добавлень

        $validator = Validator::make($request->all(), [
            'name'          => 'required|min:2|max:100',
            'surname'       => 'required|min:2|max:100',
//            'role'          => 'required',
            
//            'company'       => 'min:2|max:100',
//            'vat'           => 'required',
//            'currency'      => 'required|exists:currency,code_1c',
           
            'paymant_type'  => 'exists:characteristic_value,code_1c',
            'type_value'    => 'exists:type_price,code_1c',
//            'street'        => 'required|min:1|max:50',
//            'build'         => 'required|int',
//            'city'          => 'required|min:2|max:50',
//            'region'        => 'required|min:2|max:50',
//            'post_code'     => 'required|min:2|max:50',
//            'country'       => 'required|min:2|max:50',
//            'post_build'    => 'required|min:2|max:50',
//            'post_street'   => 'required|min:2|max:50',
//            'post_city'     => 'required|min:2|max:50',
//            'post_region'   => 'required|min:2|max:50',
//            'post_post_code'=> 'required|min:2|max:50',
//            'post_country'  => 'required|min:2|max:50',
            
            'phone'      =>'required|min:10|max:20|',
//            'phone_company'      =>'min:10|max:20|',
            'email'      =>'required|string|email|max:255|unique:users',
            'password'   =>'required|confirmed|min:5|max:30',
            'password_confirmation' => 'required|min:5|max:30',
        ]);
        

        if($validator->fails()) {
           return response()->json(['errors'=>$validator->messages()], 200);
 
        } else {
            $create = DB::table('users')->insert([
                'name'          => $request->name,
                'surname'       => $request->surname,
                'company'       => $request->company,
                'vat'           => $request->vat,
                'type_price'    => $request->type_value,
                'country'       => $request->country,
                'province'      => $request->province,
                'build'         => $request->build,
                'type_pay'      => $request->paymant_type,
                'region'        => $request->region,
                'city'          => $request->city,
                'street'        => $request->street,
                'post_code'     => $request->post_code,
                'post_country'  => $request->country,
                'post_province' => $request->province,
                'post_region'   => $request->region,
                'post_city'     => $request->city,
                'post_street'   => $request->street,
                'post_post_code'=> $request->post_code,
                'phone'         => $request->phone,
                'phone_company' => $request->phone_company,
                'email_company' => $request->email_company,
                'email'         => $request->email,
                'agent_id'      => ($request->role == 'bayer') ?  $request->type_user : '',
                'diller_id'     => ($typeUser == 'Diller') ?  Auth::user()->user_code_1c : '',
                'comment'       => $request->comment,
                'password'      => bcrypt($request->password),
                'created_at'    => date('Y-m-d H:s:i',time()),
                'updated_at'    => date('Y-m-d H:s:i',time()),
            ]);

            if($create){
//                $data = ['password' => $request->password, 'email' => $request->email ];
//                $this->SendMail($data);
                return response()->json(['ok'=>'Successful add user'], 200);
            }
      }
   
    }
    
    public function SendMail($data){
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . ' MonicaLoretti ' . " <" . ' MonicaLoretti ' . ">\r\n";
        
        $email = $data['email'];
        $text = view('email_tpl.register_dil')->with('user', $data);
        if ( mail( $email, 'Registration success on site  b2bclientssystem.com!', $text, $headers ) ){
            return TRUE;
        }
    }
    
    
    /**
     *  getUserCurrency() - тип валюти користувача
     *  userIs()          - тип користувача
     *  typeOfValue()     - тип значення ціни 
     *  getPeymentUserMethod - тип оплати
     * 
     * 
     * @param Request $request
     * @return string
     */
    public function ActionEditForm(Request $request) 
    {
        if($user = $this->getUser($request->user)) {
            if(!$currency_type = $this->getUserCurrency()) {
                dd('Не визначений тип ціни');
            }
            
            $diller = Auth::user()->user_code_1c;
            
            $typOf = $this->iKostyl($this->getUserPeimentNew($diller, '1'));

            $agent_list = $this->getAgent(); 

            $type = $this->userIs();
            
            $typeUserById = $this->typeUserByData($user);

            $pay_method = $this->iKostyl($this->getUserPeimentNew($diller, '2'));
            
            $user_payment_1c = User::where('id','=',$request->user)->first();
            
            $pay_method[$user_payment_1c->type_pay] = CharacteristicValue::where('code_1c','=',$user_payment_1c->type_pay)->value('value');
            
            $typOf[$user_payment_1c->type_price] = DB::table('type_price')->where('code_1c','=',$user_payment_1c->type_price)->value('name');
            $api= $user->country;
            $contents = view('UserCabinet::form-user-edit')->with([
                'type'          => $type,
                'typOf'         => $typOf,   
                'currency_type' => $currency_type,
                'agent_list'    => $agent_list,
                'pay_method'    => $pay_method,
                'user'          => $user,
                'typeUserById'  => $typeUserById,
                'user_pay'      => $user_payment_1c->type_pay,
                'user_price'    => $user_payment_1c->type_price,
                'api'           => $api,
                
            ])->render();
        
            return $contents;
        } else {
            dd('User not found');
        }
    }   
    
    
    /**
     * 
     * @param Request $request
     * return object
     */
    public function ActionEditUser(Request $request) 
    {
        if( $user = $this->getUser($request->id)) {
            $validator = Validator::make($request->all(), [
                'name'          => 'required|min:2|max:100',
                'surname'       => 'required|min:2|max:100',
                'role'          => 'required',
                'company'       => 'required|min:2|max:100',
                'vat'           => 'required',
                'currency'      => 'required|exists:currency,code_1c',
                'paymant_type'  => 'required',
                'type_value'    => 'required',
                'street'        =>'required|min:2|max:50', 
                'build'         => 'required',
                'city'          =>'required|min:2|max:50',
                'region'        =>'required|min:2|max:50', 
                'post_code'     =>'required|min:2|max:50',
                'country'       =>'required|min:2|max:50',   
                'post_build'    =>'required|min:1|max:50',
                'post_street'   =>'required|min:2|max:50',
                'post_city'     =>'required|min:2|max:50',
                'post_region'   =>'required|min:2|max:50',  
                'post_post_code'=>'required|min:2|max:50',
                'post_country'  =>'required|min:2|max:50',
                'phone'      =>'required|min:10|max:20|',
                'phone_company'      =>'required|min:10|max:20|',
                //'email'      =>'required|string|email|max:255|unique:users,email,'.$user->id,
//                'password'   =>'required|confirmed|min:5|max:30',
//                'password_confirmation' => 'required|min:5|max:30',
            ]);
        
            $validator->sometimes('password','required|confirmed|min:5|max:30', function($input) {   
                return strlen($input->password)>0 or strlen($input->password_confirmation)>0;    
            });
       
            if($request->role == 'buyer') {
               $this->type = $request->type_user;
            }
            

            if($validator->fails()) {
               return response()->json(['errors'=>$validator->messages()], 200);
 
            } else { 
                $update= DB::table('users')->where('id', '=', $user->id)->update([ 
                    'name'       => $request->name,
                    'surname'    => $request->surname,
                    'company'    => $request->company,
                    'vat'        => $request->vat,
                    'type_price' => $request->type_value,
                    'country'    => $request->country,
                    'build'      => $request->build,
                    'type_pay'     =>$request->paymant_type,
                    'region'       => $request->region,
                    'province'     => $request->province,
                    'city'         => $request->city,
                    'street'       => $request->street,
                    'post_code'    => $request->post_code,
                    'post_build'   => $request->post_build,
                    'post_country' => $request->country,
                    'post_province' => $request->province,
                    'post_region'  => $request->region,
                    'post_city'    => $request->city,
                    'post_street'  => $request->street,
                    'post_post_code' => $request->post_code,
                    'phone'     => $request->phone,
                    'phone_company'     => $request->phone_company,
                    //'email'     => $request->email,
                    'agent_id'  =>  $this->type,
                    //'diller_id' => ($request->role == 'agent') ?  Auth::user()->user_code_1c : '', 
                    'comment'   => $request->comment,
                    'password'  =>  ($request->password !==null)? $user->password = bcrypt($request->password): $user->password = $user->password,       
                ]);
                
                if($update){
                    return response()->json(['ok'=>'Successful edit user'], 200);
                }  else {
                  return response()->json(['error'=>'UPDATE USER'], 200);
                }
          }    
        
          
            
        } else {
          return response()->json(['error'=>'not found'], 200);
        }
    }
    
     
    
    /*
     * Delete user
     * @param id - int
     * return - json status
     */
    public function DestroyUser(Request $request) 
    { 
        $user = $this->getUser($request->id);
        if($user) {
            $delete =  DB::table('users')->where('id', '=', $user->id)->delete();
            if($delete) {
                $status = [ 'status' =>$delete ];
            } else {
               return response()->json( [ 'status' =>0 ]);
            }
        }
        return response()->json($status);
     }

    /*
    * Show all orders for user
    * @param id - int
    * @return object
    */
    public function GetOrdersByUser(Request $request)
    {
        $user_id = $request->id;

        $user_1c_code = User::where('id', '=', $user_id)->pluck('user_code_1c')->first();

        $carts = $this->getBuyerHistory($user_1c_code);

        return view('UserCabinet::history-detail-user')->with([
            'carts'        => $carts,
        ]);

    }
  }

