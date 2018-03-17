<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Models\User;
use App\Models\UserWebTypePrice;
use App\Models\CharacteristicValue;
use App\Models\TypePrice;
use Illuminate\Support\Facades\Input;
use Validator;
use Gate;
use Auth;
use DB;



class AdminController extends Controller
{
    use UserTrait;
    private $agent_list = '';
    private $type       = '';
    public function __construct() 
    {
        $this->middleware('auth');  
        if(!Auth::user()->is_admin == true) {
            return dd('you is not admin');
        }
    }
    

    public function Dashboard() 
    {   
        $users  = User::all();
        foreach ($users as $user)
        {
            $user->diller_id = User::where('user_code_1c','=',$user->diller_id)->value('name');
            $user->agent_id = User::where('user_code_1c','=',$user->agent_id)->value('name');
        }
        return view('adminPanel.user.list')->with('users',$users);
    }
   
    public function userEditForm(Request $request, $id)
    { 

        if($user = $this->getUser($request->id)) {

            $typOf        = $this->typeValue();
            $agent_list   = $this->getAgentAdmin(); 
            $type         = $this->userIs();  
            $typeUserById = $this->typeUserByData($user);
            $pay_method   = $this->getPeymentUserMethodAdmin($user->type_pay);
            $selected_type_value = UserWebTypePrice::where('type', '=', 1)->where('user_id', '=', $user->id)->pluck('code_1c_pr');
            $user->diller_id = User::where('user_code_1c','=',$user->diller_id)->value('name');
            $user->agent_id = User::where('user_code_1c','=',$user->agent_id)->value('name');
            $api = 0;
            if($user->country)
                $api = 1;
            $selected_payment_type = UserWebTypePrice::where('type', '=', 2)->where('user_id', '=', $user->id)->pluck('code_1c_pr');
    
        return  view('adminPanel.user.edit')->with([
            'type'          => $type,
            'typOf'         => $typOf,   
            'agent_list'    => $agent_list,
            'pay_method'    => $pay_method,
            'user'          => $user,
            'typeUserById'  => $typeUserById,
            'selected_type_value'   => $selected_type_value,
            'selected_payment_type' =>$selected_payment_type,
            'api'          => $api
        ]);

        } else {
            dd('Юзера не знайдено');
        }  
    }
    
  
    
    
    
    /**
     * 
     * @param Request $request
     * return object
     */
    public function ActionEditUser(Request $request, $id) 
    {
        if( $user = User::find($id)) {

            $validator = Validator::make($request->all(), [
                'name'          => 'required|min:2|max:100',
                'surname'       => 'required|min:2|max:100',
              //  'role'          => 'required',
                'company'       => 'min:2|max:100',
                //'vat'           => 'required',
             //   'currency'      => 'required|exists:currency,code_1c',
             //   'paymant_type'  => 'required|exists:characteristic_value,code_1c',
             //   'type_value'    => 'required|exists:type_price,code_1c',
//                'street'        =>'required|min:2|max:50',
//                'build'         => 'required',
//                'city'          =>'required|min:2|max:50',
//                'region'        =>'required|min:2|max:50',
//                'post_code'     =>'required|min:2|max:50',
//                'country'       =>'required|min:2|max:50',
               // 'post_build'    =>'required|min:1|max:50',
//                'post_street'   =>'required|min:2|max:50',
//                'post_city'     =>'required|min:2|max:50',
//                'post_region'   =>'required|min:2|max:50',
//                'post_post_code'=>'required|min:2|max:50',
//                'post_country'  =>'required|min:2|max:50',
                'phone'      =>'required|min:10|max:20|',
                'phone_company'      =>'min:10|max:20|',
                //'email'      =>'required|string|email|max:255|unique:users,email,'.$user->id,
//                'password'   =>'required|confirmed|min:5|max:30',
//                'password_confirmation' => 'required|min:5|max:30',
            ]);
        
            $validator->sometimes('password','required|confirmed|min:5|max:30', function($input) {   
                return strlen($input->password)>0 or strlen($input->password_confirmation)>0;    
            });
       
            if($request->role == 'buyer') {
               $this->type = $request->type_user;
            } else {
              $this->type = '';
            }
            

            if($validator->fails()) {
                  return redirect()->route('users-edit-form',$user->id)->withErrors($validator )->withInput(); 
            } else { 
                $update= $user->update([ 
                    'name'       => $request->name,
                    'surname'    => $request->surname,
                    'company'    => $request->company,
                    'vat'        => $request->vat,
                    'type_price' => $request->user_type_value,
                    'country'    => $request->country,
                    'build'      => $request->build,
                    'type_pay'     =>$request->user_paymant_type,
                    'province'     => $request->province,
                    'region'       => $request->region,
                    'city'         => $request->city,
                    'street'       => $request->street,
                    'post_code'    => $request->post_code,
                    'post_build'   => $request->post_build,
                    'post_country' => $request->country,
                    'post_province'=> $request->post_province,
                    'post_region'  => $request->region,
                    'post_city'    => $request->city,
                    'post_street'  => $request->street,
                    'post_post_code' => $request->post_code,
                    'phone'     => $request->phone,
                    'phone_company'     => $request->phone_company,
                    'email'     => $request->email,
                    'agent_id'  =>  $this->type,
                    //'diller_id' => ($request->role == 'agent') ?  Auth::user()->user_code_1c : '', 
                    'comment'   => $request->comment,
                    'password'  =>  ($request->password !==null)? $user->password = bcrypt($request->password): $user->password = $user->password,       
                ]);

                if($update){
                  
                    $input_type_value= Input::get('type_value'); 
                    $input_payment_type = Input::get('paymant_type');
                    if($input_payment_type){
                    $type_pr      = TypePrice::whereIn('code_1c',$input_type_value)->select('name','code_1c')->get();

                    $pay_type = CharacteristicValue::whereIn('code_1c',$input_payment_type)->select('value','code_1c')->get();

                    if(count($type_pr)>0) {
                        $this->delTypeWeb($user->id,1);
                        foreach ($type_pr as $row) {
                            $this->insertWebType($row->name, $user, 1, $row->code_1c);
                        }   
                    }

                    if(count($pay_type)>0) {
                        $this->delTypeWeb($user->id,2);
                        foreach ($pay_type as $row) {
                            $this->insertWebType($row->value, $user, 2, $row->code_1c);
                        }
                    }
                    }
                  
                  
                     return redirect()->route('dashboard')->with('status','Відредаговано!');
                }  else {
                  return response()->json(['error'=>'UPDATE USER'], 200);
                }
          }    
        
          
            
        } else {
          return response()->json(['error'=>'not found'], 404);
        }
    
    
    }
    
    
    
    public function insertWebType($row, $user, $type, $code_1c) 
    {
       return DB::table('user_web_type_price')->insert([
           'user_id'        => $user->id,
           'type'           => $type,
           'web_type_price' => $row,
           'code_1c_pr'     => $code_1c
       ]);
    }
    
    public function delTypeWeb($user, $type) 
    {
        return UserWebTypePrice::where('user_id', '=', $user)->where('type','=',$type)->delete();
    }
    
    
    
    
     /**
     * Дістаємо типи цін юзера
     * 
     * @return object
     */
    
    private function typeValue() 
    {
        $sql = DB::table('type_price')->distinct()->pluck('name', 'code_1c');
        return $sql;
    }
    
    
    
    public function getAgentAdmin() 
    {
         return DB::table('users')->where('user_is_synk', 1)
                                 ->where('diller_id','!=','' )
                                 ->where('agent_id', '=', '')
                                 ->pluck('name', 'user_code_1c');
    }
    
    
    /**
     * Дістаємо доступний тип оплати юзера
     * 
     * @return object or null
     */
    private function getPeymentUserMethodAdmin()
    {
        $rezult =  DB::table('characteristic_value')->where('code_1c_characteristic', '=', 'a791e40f-04b7-11e7-a578-00215a4648ba')->distinct()->pluck('value','code_1c');
        return (count($rezult) >0)? $rezult : null ;
  
    }
    
    public function userDestroy($id) {
        if(!$user = User::find($id))
            return response()->json(['status'=>'error']);
            
        $rezult = $user->delete();
        if($rezult)
            return response()->json(['status'=>'ok']);
        else
            return response()->json(['status'=>'error']);
    } 
}
