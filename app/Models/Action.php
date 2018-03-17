<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
  
    protected $table = 'action';
    protected $fillable = [ 'type', 'sign', 'sum','active' ];
    public $timestamps  = false;


   public function actionValue()
   {
        return $this->hasMany('App\Models\ActionValue', 'action_id', 'id');
   }
   
  
}
