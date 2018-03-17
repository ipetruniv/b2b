<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use App;
use App\Traits\Common;
use Session;

class CustomAuthController extends Controller
{

    use Common;

    public function register(Request $request)
    {    

        $this->validate($request, [
            'name'     =>'required|min:2|max:50',
            'surname'     =>'required|min:2|max:50',
//            'company'     =>'min:2|max:50',
//            'country'     =>'required|min:2|max:50',
//            'region'     =>'required|min:2|max:50',
//            'city'     =>'required|min:2|max:50',
//            'street'     =>'required|min:2|max:50',
//            'post_code'     =>'required|min:2|max:50',
//            'post_country'     =>'required|min:2|max:50',
//            'post_region'     =>'required|min:2|max:50',
//            'post_city'     =>'required|min:2|max:50',
//            'post_street'     =>'required|min:2|max:50',
//            'post_post_code'     =>'required|min:2|max:50',
            'phone'    =>'required|min:10|max:20|',
//            'phone_company'    =>'min:10|max:20|',
//            'email_company'    =>'max:150|',
            'email'    =>'required|string|email|max:255|unique:users',
            'password'  =>'required|confirmed|min:5|max:30',
            'password_confirmation' => 'required|min:5|max:30',
//            'captcha'   => 'required',
//            'comment' => 'min:2',
//            'vat' => 'min:2',
        ]);
        $user_create = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'company' => $request->company,
            'country' => $request->country,
            'province' => $request->province,
            'region' => $request->region,
            'city' => $request->city,
            'street' => $request->street,
            'build' => $request ->build,
            'post_code' => $request->post_code,
            'post_country' => $request->post_country,
            'post_province' => $request->province,
            'post_region' => $request->post_region,
            'post_city' => $request->post_city,
            'post_street' => $request->post_street,
            'post_post_code' => $request->post_code,
            'phone' => $request->phone,
            'phone_company' => $request->phone_company,
            'email_company' => $request->email_company,
            'email' => $request->email,
            'login' => $request->email,
            'password' => bcrypt($request->password),
            'comment' => $request->comment,
            'vat' => $request->vat
        ]);
//dd($request->id);

        if ($user_create){
            $data = ['password' => $request->password, 'email' => $request->email,'username'=>$request->name ];
            
            $data['theme'] = __('email.registerTheme');
            $data['text']  = __('email.registerText',['email'=>$data['email']]);
            $this->SendMail($data);

            return response()->json(['message' => 'You successful register a new user!']);
        }
    }
    public function login(Request $request)
    {   
        $request->email = $request->login;
        $validation=Validator::make($request->all(), [
            'login' => 'required|string|email|max:255',
            'password_login' => 'required|min:5|max:30',
        ]);

        if($validation->fails()) {
            return redirect()->route('login')->with('error_registration','Login or Password entered incorrectly');
        }
        
        
            
        if (Auth::attempt(['email' => $request->login, 'password' => $request->password_login])){
          
            if(Auth::user()->is_admin == true) {
                return redirect()->route('dashboard');
            }
          
          //  return response()->json(['message' => 'You are login!']);
            $locale = Auth::user()->language;
            Session::put('locale', $locale);
            App::setLocale($locale);
            return redirect()->route('catalog-list');
        } else { 
        
            return redirect(App::getLocale().'/login')->with('error_registration', __('messages.LOGIN_VALID_DATA'));
        }
    }

}