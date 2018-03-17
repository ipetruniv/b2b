<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePrice extends Model 
{
  /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'type_price';
    protected $fillable = ['code_1c', 'name', 'code_1c_currency'];
    public $timestamps  = false;

    
    
    
    
}
