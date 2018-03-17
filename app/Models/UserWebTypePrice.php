<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWebTypePrice extends Model 
{
  /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
   
    protected $table = 'user_web_type_price';
    
    protected $primaryKey = 'id';   
    protected $fillable = ['user_id', 'web_type_price','type', 'code_1c_pr'];
    public $timestamps = false;
    
    
    
}
