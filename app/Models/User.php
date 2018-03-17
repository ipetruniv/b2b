<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    public $dillerName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_code_1c', 'name', 'password', 'email', 'user_is_synk', 'surname',
        'company', 'vat', 'country', 'region', 'city', 'street', 'build', 'post_code',
        'is_legal', 'phone', 'diller_id', 'agent_id', 'cf', 'address', 
        'type_price', 'updated_at', 'type_pay', 
        'comment','post_country','post_region','post_city','post_street','post_post_code','email_company','phone_company','vat','id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    
    /**
     * @param string $code_1c
     * @return boolean
     */
    public function iSsetUser($code_1c) 
    {
        return $this->where('user_code_1c', '=', $code_1c)->first();
    }
    
    public function getTypePrice() 
    {
        return $this->hasOne('App\Models\TypePrice','code_1c', 'type_price');
    }

    public function getDiller()
    {
        return $this->belongsTo('App\Models\User', 'diller_id', 'user_code_1c');
    }

    public function getAgent()
    {
        return $this->belongsTo('App\Models\User', 'agent_id', 'user_code_1c');
    }

    public function getChildAgent()
    {
        return $this->hasMany('App\Models\User','agent_id','user_code_1c');
    }

    public function getChildDiller()
    {
        return $this->hasMany('App\Models\User','diller_id','user_code_1c');
    }


      

     /**
     * 
     * @param object $xml
     * @return object
     */
    public function createUser($xml) 
    {   
            $password = str_random(8);        
            $create = $this->create([
                'user_is_synk' => 1,
                'name'         => $xml->name,
                'email'        => $xml->email,
                'user_code_1c' => $xml->code_1c,
                'is_legal'     => $xml->is_legal,
                'VAT'          => $xml->VAT,
                'diller_id'    => $xml->diller_id,
                'agent_id'     => $xml->agent_id,
                'cf'           => $xml->cf,
                'password'     => Hash::make($password),
                'type_price'   => $xml->type_price,
                'address'      => $xml->address,
                'type_pay'     => $xml->type_pay,
            ]); 
            if($create) return ['email'=>$xml->email,'password'=>$password];
            
    }
    
    
    
    
    /**
     * 
     * @param object $user
     * @param object $data
     * @return boolean
     */
    public function EditUser($data, $user) 
    {
        return $user->update([
            'name'    => $data->name,
            'email'   => $data->email,
            'surname' => $data->surname,
            'company' => $data->company,
            'vat'     => $data->VAT,
            'country' => $data->country,
            'region'  => $data->region,
            'city'    => $data->city,
            'street'  => $data->street,
            'build'   => $data->build,
            'post_code'    => $data->post_code,
            'is_legal'     => ($data->is_legal)?$data->is_legal: 0,
            'phone'        => $data->phone,
            'diller_id'    => $data->diller_id,
            'agent_id'     => $data->agent_id,
            'cf'           => $data->cf,
            'type_price'   => $xml->type_price,
            'address'      => $xml->address,
            'type_pay'     => $xml->type_pay,
        ]);

    }
    
     /**
     * @param string $email
     * @return boolean
     */
    public function IsIssetUserEmail($email)
    {
        $match=preg_match(' /^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,10})/',$email,$mail);
        if($match){
            if($this->where('email', '=', $mail[0])->first()){
                return ['email'=>$mail[0],'check'=>'true'];}
            else {
                return ['email'=>$mail[0],'check'=>false];}
        }else 
            return 'error';
    }
    
    
    /**
     * 
     * @param object $xml
     * @return object
     */
    public function updateUser($xml) 
    {   
        return  $this->where('id', '=',$xml->web_id )->update([
            'name'         => $xml->name,
            'user_code_1c' => $xml->code_1c,
            'is_legal'     => $xml->is_legal,
            'VAT'          => $xml->VAT,
            'diller_id'    => $xml->diller_id,
            'agent_id'     => $xml->agent_id,
            'cf'           => $xml->cf,
            'type_price'   => $xml->type_price,
            'address'      => $xml->address,
            'type_pay'     => $xml->type_pay,
            'user_is_synk' => 1,
        ]); 
      
    }

    public function getRole()
    {
        if(!$this->issetParent() AND $this->issetChilds())
                return 'Diller';
        elseif($this->issetParent() AND $this->issetChilds())
                return 'Agent';
        else
                return 'Buyer';
    }

    public function issetChilds()
    {

        // dd(count($this->getChildAgent));
        // $child = $this->where('diller_id', '=' ,$this->user_code_1c)
        //             ->orWhere('agent_id',  '=' ,$this->user_code_1c)
        //             ->first();
        // if($child)
        //     return true;
        // return false;
        // 
        if(count($this->getChildDiller) OR count($this->getChildAgent))
            return true;
        return false;
    }

    public function issetParent()
    {
        if($this->diller_id or $this->agent_id)
            return true;
        return false;
    }

    public function getFirstChild($code_1c = false)
    {
        $child = $this->where('agent_id', '=', $this->user_code_1c)
                    ->orWhere('diller_id','=', $this->user_code_1c)
                    ->first();
        return (count($child) > 0)
                ?($code_1c)
                    ?$child
                    :$child->user_code_1c 
                : NULL ;
    }
    
}
