<?php

namespace App\Modules\UserCabinet\Traits;
use DB;
use Auth;
use App\Models\User;

trait UserTrait {

    /*
     * Вибираємо юзерів діллера
     * 
     * @return object
     */
    
    public function getUserType()
    {
        return User::where('user_is_synk', 1)
                                 ->where('diller_id','=', Auth::user()->user_code_1c)
                                 ->get();
    }
    
    /*
     * Вибираємо юзерів агента
     * 
     * @return object
     */ 
    public function getUserAgent()
    {
        return User::where('user_is_synk', 1)
                                 ->where('agent_id','=', Auth::user()->user_code_1c)               
                                 ->get();    
    }
    
    /*
     * Вибираємо інфу по простому
     * даному юзеру
     * 
     * @return object
     */
    public function getUserInfo() 
    {
       return User::where('email', '=',Auth::user()->email )->get();
    }
    
    
    /**
     * Вибираємо агентів діллера
     * 
     * @return object
     */
    public function getAgent() 
    {
        return User::where('user_is_synk', 1)
                                 ->where('diller_id','=', Auth::user()->user_code_1c )
                                 ->where('agent_id', '=', '')
                                 ->pluck('name', 'user_code_1c');
    }
    
    
    public function getUserCurrency()
    {
        $currency = DB::table('type_price as tp')
                      ->join('currency as cr', 'tp.code_1c_currency', '=', 'cr.code_1c' )
                      ->where('tp.code_1c','=', Auth::user()->type_price)
                      ->pluck('cr.name','tp.code_1c_currency');
       
        return $currency;
    }
    
    
    private function getUser($id) 
    {
        return  User::where('id', '=', $id)->first();
    }

    
    /**
     * 
     * Тип юзера по code_1c
     * @param string $id
     * @return object
     */
    private function getUserByCode($code) 
    {
        return  DB::table('users')
                ->where('user_code_1c', '=', $code)
                ->whereNotNull('diller_id')
                ->whereNotNull('type_price')
                ->first();
    }
    
    
    
    /**
     * Оприділяємо тип юзера
     * 
     * @return string
     */
 
    private function userIs()
    {
        if(!Auth::user()->diller_id && !Auth::user()->agent_id) { // якщо юзер діллер
            $type = 'Diller';
        } elseif(Auth::user()->diller_id !== null && Auth::user()->agent_id == null) { // якщо юзер агент
            $type = 'Agent';
        } elseif(Auth::user()->diller_id !== null && Auth::user()->agent_id !== null) { // якщо простий юзер
            $type = 'Bayer';
        } 
        
        return $type;
    }
    
    
    
    /**
     * Оприділяємо тип ю
     * 
     * @param object $user
     * @return object
     */
    
    private function typeUserByData($user)
    {
        if(!$user->diller_id && !$user->agent_id) {                      // якщо юзер діллер
            $type = 'Diller';
        } elseif($user->diller_id !== null && $user->agent_id == null) { // якщо юзер агент
            $type = 'agent';
        } elseif($user->diller_id !== null && $user->agent_id !== null) { // якщо простий юзер
            $type = 'buyer';
        } elseif($user->diller_id == '' && $user->agent_id !== null) {    // якщо простий юзер
            $type = 'buyer';
        } 
        
        return $type;
    }
    
    
    
    /**
     * Дістаємо типи цін юзера
     * 
     * @return object
     */
    private function typeOfValue() 
    {
        $sql = DB::table('type_price')->where('code_1c', '=',Auth::user()->type_price)->pluck('name', 'code_1c');
        return $sql;
    }
    
     
    /**
     * Дістаємо доступний тип оплати юзера
     * 
     * @return object or null
     */
    private function getPeymentUserMethod($type_pay = null)
    {
        $rezult =  DB::table('characteristic_value')->where('code_1c', '=', ($type_pay)? $type_pay : Auth::user()->type_pay)->pluck('value','code_1c');
        return (count($rezult) >0)? $rezult : null ;
  
    }
    
    
    
    
    /**
     * 
     * Витянути юзерів анента
     * 
     * @param string $id_agent
     * @return object
     */
    
    private function getAgentuser($id_agent) 
    { 
       return User::where('agent_id', '=',$id_agent)
                                ->where('user_is_synk', '=', 1)
                                ->whereNotNull('type_price')
                                ->whereNotNull('type_pay')
                                ->get();
    }
    
    
    
    /**
     * 
     * Витянути активного агента
     * 
     * @param string $id_agent
     * @return object
     */
    private function checkAgent($id_agent) 
    {
        return User::where('agent_id', '=',$id_agent)
                                ->where('user_is_synk', '=', 1)
                                ->whereNotNull('type_price')
                                ->whereNotNull('type_pay')
                                ->first();
    }

    /**
     * Дістаємо доступний тип оплати юзера
     *
     * @return object or null
     */
    private function getPaymentUserMethod($user, $type_pay = null)
    {
        $user = User::where('user_code_1c', '=', $user)->first();

        $rezult =  DB::table('characteristic_value')->where('code_1c', '=', ($type_pay)? $type_pay : $user->type_pay)->first();
        return (count($rezult) >0)? $rezult : null ;

    }
    
   
    

     /**
     * Вибираємо агентів діллера
     * 
     * @return object
     */
    private function getAgentCart() 
    {
        return User::where('user_is_synk', 1)
                                 ->where('diller_id','=', Auth::user()->user_code_1c )
                                 ->where('agent_id', '=', '')
                                 ->get();
    }
    
    
    private function getUserPeiment($agent, $user) 
    { 
        return DB::table('users')
                ->join('type_price', 'users.type_price', '=', 'type_price.code_1c')
                ->where('users.user_code_1c', '=', $user)
//                ->where('users.agent_id', '=',$agent)
                ->whereNotNull('users.type_price')
                ->select('type_price.name', 'type_price.code_1c','users.type_price',
                        'type_price.code_1c_currency', 'users.country',
                        'users.company','users.region', 'users.city',
                        'users.street', 'users.build', 'users.post_code',
                        'users.phone', 'users.email', 'users.surname')
                ->first();
    }
    
    
    private function getUserPeimentWithoutAgent($user) 
    { 
        return DB::table('users')
                ->join('type_price', 'users.type_price', '=', 'type_price.code_1c')
                ->where('users.user_code_1c', '=', $user)
                ->whereNotNull('users.type_price')
                ->select('*')
//                ->select('type_price.name', 'type_price.code_1c','users.type_price',
//                        'type_price.code_1c_currency', 'users.country', 'users.agent_id',
//                        'users.company','users.region', 'users.city',
//                        'users.street', 'users.build', 'users.post_code',
//                        'users.phone', 'users.email', 'users.surname')
                ->first();
    }
    
    private function getUserPeimentNew($user,$type) {
        return DB::table('users')
                ->join('user_web_type_price', 'users.id', '=', 'user_web_type_price.user_id')
                ->where('users.user_code_1c', '=', $user)
                ->where('user_web_type_price.type','=',$type)
                ->select('user_web_type_price.web_type_price', 'user_web_type_price.code_1c_pr')
                ->get();
    }


    private function getProductCatalog($type_price=null)
    { 
        return  DB::table('products as pr')
                     ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items') 
                     ->where('pp.code_1c_price_type','=', $type_price ?? Auth::user()->type_price)
                     ->select('pr.name','pp.price_value', 'pr.id', 'pr.code_1c')
                     ->distinct()
                     ->get();
    }
    
    
    
    private function getProductCatalogUser()
    { 
           return DB::table('remains')
                  ->leftjoin('size_color_access as sca','remains.code_1c_characteristic_color_value','=', 'sca.code_1c_characteristic_value')
                  ->leftjoin('characteristic_value as ch','remains.code_1c_characteristic_color_value','=', 'ch.code_1c')
                  ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                  ->where('sca.not_enabled', '=', 0)
                  ->where('remains', '>', 0)
                  ->distinct()
                  ->orderBy('ch.sort_color', 'asc')
                  ->orderBy('remains.name_characteristic_size_value', 'asc')
                  ->get();
              
    }
    
    
    
    private function switcType($data) 
    {
        switch($data) {
            case "Diller" :
                $users = $this->getAgentCart(); 
                break;  
            case "Agent":
                $users = $this->getUserAgent();
                break;  
            default:
               $users = $this->getUserInfo();
        }
        return $users;
        
    }
    
    public function userAgent($data) 
    {
        return User::where('user_is_synk', 1)
                                 ->where('diller_id','=', Auth::user()->user_code_1c)    
                                 ->where('user_code_1c', '=', $data->agent_id)
                                 ->first();  
    }
    
    /**
     * Дістаємо юзерів діллера (не агентів!)
     * @return object
     */ 
    public function getUserDiller()
    {
        return User::where('user_is_synk', 1)
                                 ->where('diller_id','=',Auth::user()->user_code_1c)    
                                 ->where('agent_id', '!=', '')
                                 ->get();    
    }
    
    public function iKostyl($param) { // да жесть но pluck нормально работать не хочет
        $bar = [];
        foreach($param as $foo)
            $bar[$foo->code_1c_pr]=$foo->web_type_price;
        return $bar;
    }

}