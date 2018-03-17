<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionValue extends Model
{

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table    = 'action_value';
    protected $fillable = [ 'action_id', 'size', 'color', 'product', 'collection', 'user_id', 'brend' ];
    public $timestamps  = false;


   
}
