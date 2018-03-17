<?php

namespace App\Modules\UserCabinet\Controllers;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CharacteristicValue;
use Validator;
use Auth;
use DB;

class UserSettingsController extends Controller
{
    use UserTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
 

    public function UserSettingForm(){
     
        if ($user = $this->getUser(Auth::user()->id)) {
            if(!$currency_type = $this->getUserCurrency()) {
                dd('Не визначений тип ціни');
            }
            
            $agent_list = $this->getAgent(); 
            $type = $this->userIs();
            $typeUserById = $this->typeUserByData($user);
            
            $user_1C = Auth::user()->user_code_1c;
            $typOf = $this->iKostyl($this->getUserPeimentNew($user_1C, '1'));
            $pay_method = $this->iKostyl($this->getUserPeimentNew($user_1C, '2'));
            $user_payment_1c = User::where('id','=',$user->id)->first();
            if($user_payment_1c->type_pay)
                $pay_method[$user_payment_1c->type_pay] = CharacteristicValue::where('code_1c','=',$user_payment_1c->type_pay)->value('value');
            if($user_payment_1c->type_price)
                $typOf[$user_payment_1c->type_price] = DB::table('type_price')->where('code_1c','=',$user_payment_1c->type_price)->value('name');
            $api = $user->country;
            
            $contents = view('UserCabinet::form-user-settings')->with([
                'type'          => $type,
                'typOf'         => $typOf,
                'currency_type' => $currency_type,
                'agent_list'    => $agent_list,
                'pay_method'    => $pay_method,
                'user'          => $user,
                'typeUserById'   =>$typeUserById,
                'api'           => $api
                
            ])->render();

            return $contents;
        }
        else {
            dd('User not found');
        }
    }

    public function UserSetting(Request $request)
    {

        if ($user = $this->getUser(($request->id)?$request->id:Auth::user()->id)){
            $validator = Validator::make($request->all(), [
                'name'          => 'required|min:2|max:100',
                'surname'       => 'required|min:2|max:100',
                'company'       => 'min:2|max:100',
//               'vat'           => 'required',
//                'street'        =>'required|min:2|max:50',
//                'build'         => 'required|int',
//                'city'          =>'required|min:2|max:50',
//                'region'        =>'required|min:2|max:50',
//                'post_code'     =>'required|min:2|max:50',
//                'country'       =>'required|min:2|max:50',
//                'post_build'    =>'required|min:2|max:50',
//                'post_street'   =>'required|min:2|max:50',
//                'post_city'     =>'required|min:2|max:50',
//                'post_region'   =>'required|min:2|max:50',
//                'post_post_code'=>'required|min:2|max:50',
                //  'post_country'  =>'required|min:2|max:50',
                'phone'      =>'required|min:10|max:20|',
                'phone_company'      =>'min:10|max:20|',
                'email'      =>'required|string|email|max:255|unique:users,email,'.$user->id,
//                'password'   =>'required|confirmed|min:5|max:30',
//                'password_confirmation' => 'required|min:5|max:30',
            ]);

            $validator->sometimes('password','required|confirmed|min:5|max:30', function($input) {
                return strlen($input->password)>0 or strlen($input->password_confirmation)>0;
            });

            if($validator->fails()) {
//                dd('You here!');
                return response()->json(['errors'=>$validator->messages()], 200);
            } else {
                $update = DB::table('users')->where('id', '=', ($request->id)?$request->id:Auth::user()->id)->update([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'company' => $request->company,
                    'vat' => $request->vat,
                    'country' => $request->country,
                    'build' => $request->build,
                    'province' => $request->province,
                    'region' => $request->region,
                    'city' => $request->city,
                    'street' => $request->street,
                    'post_code' => $request->post_code,
                    'post_country' => $request->post_country,
                    'post_province' => $request->post_province,
                    'post_region' => $request->post_region,
                    'post_city' => $request->post_city,
                    'post_street' => $request->post_street,
                    'post_build' => $request->post_build,
                    'post_post_code' => $request->post_post_code,
                    'phone' => $request->phone,
                    'phone_company' => $request->phone_company,
                    'email' => $request->email,
                    'email_company' => $request->email_company,
                    'comment' => $request->comment,
                    'password' => ($request->password !== null) ? $user->password = bcrypt($request->password) : $user->password = $user->password,
                ]);

                if ($update) {
                    return response()->json(['ok' => 'Successful edit user'], 200);
                }
            }
        }
        else {
            return response()->json(['error'=>'not found'], 200);
        }
    }

}