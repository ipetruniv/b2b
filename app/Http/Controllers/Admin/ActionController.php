<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\UserCabinet\Traits\UserTrait;
use App\Models\User;
use App\Models\Action;
use App\Models\ActionValue;
use App\Models\Characteristic;
use App\Models\CharacteristicValue;
use App\Models\Products;
use App\Models\ItemGroup;

use Illuminate\Support\Facades\Input;
use Validator;
use Gate;
use Auth;
use DB;



class ActionController extends Controller
{
    use UserTrait;
    
    public function __construct() 
    {
        $this->middleware('auth');  
        if(!Auth::user()->is_admin == true) {
            return dd('you is not admin');
        }
    }
    

    public function Actions() 
    {   
        
        $actions = Action::get();
        foreach ($actions as $action) {
            $action = $this->Conc2tables($action);
            if($action)
                $action = $this->realName($action,$action->attribute);
        }
        
        return view('adminPanel.action.list')->with('actions',$actions);
    }
    
    
    public function FormAdd() 
    {
        $arrChar = $this->getAllCharacteristic();
        $size = $arrChar[0];
        $color = $arrChar[1];
        $product = $arrChar[2];
        $collection = $arrChar[3];
        $users = $arrChar[4];
        $brend = $arrChar[5];
        return view('adminPanel.action.addform')
                ->with('size', $size)
                ->with('color',$color)
                ->with('product',$product)
                ->with('collection',$collection)
                ->with('users',$users)
                ->with('brend',$brend);
    }
    
    public function actionCreate(Request $request) 
    {
        
//                dd($request);
        //добавити валідаці та перевірки
      
        $validator = Validator::make($request->all(), [
            'type'  => 'required',
            'sum' => 'required',
        ]); 
        
        if($validator->fails()) {
            return redirect()->route('users-add-form')->withErrors($validator )->withInput(); 
        }
        if($request->type ==1 ) { //якщо націнка
            $input_size = Input::get('size'); 
            $action = Action::create([
                'type' =>1,
                'sign' => 0,
                'sum'  => $request->sum,
                'active' => ($request->active == '0')? 0 : 1,
            ]); 
            if($action) {
                $sizes = CharacteristicValue::whereIn('code_1c',$input_size)->get();
                foreach($sizes as $size) {
                    $rezult = $this->createActionValue($size->code_1c,$action->id,'size');
                }
            }            
        }
        elseif($request->type ==2) {
            
            $validator = Validator::make($request->all(),[$request->attribute  => 'required',]);
            if($validator->fails()) {
                return redirect()->route('users-add-form')->withErrors($validator )->withInput(); 
            }
            
            $action = Action::create([
                'type' =>2,
                'sign' => $request->sign,
                'sum'  => $request->sum,
                'active' => ($request->active == '0')? 0 : 1,
            ]); 
            
            if($action) {
            $input = Input::get($request->attribute);
                if($request->attribute == 'color' or $request->attribute == 'size')
                    $attributes = CharacteristicValue::whereIn('code_1c',$input)->get();
                
                elseif($request->attribute == 'product')
                    $attributes = Products::whereIn('code_1c',$input)->get();
                
                elseif($request->attribute == 'collection' or $request->attribute == 'brend')
                    $attributes = ItemGroup::whereIn('items_group_code_1c',$input)->get();
                                
                elseif($request->attribute == 'user_id')
                    $attributes = User::whereIn('user_code_1c',$input)->get();
                
            foreach($attributes as $attribute) {
                if($request->attribute == 'collection' or $request->attribute == 'brend')
                    $rezult = $this->createActionValue($attribute->items_group_code_1c,$action->id,$request->attribute);
                elseif($request->attribute == 'user_id')
                    $rezult = $this->createActionValue($attribute->user_code_1c,$action->id,$request->attribute);
                else  
                    $rezult = $this->createActionValue($attribute->code_1c,$action->id,$request->attribute);
                }
            }
            
        }
         else {
            dd('NOT FOUND');
        }
        if($action && $rezult) {
               return redirect()->route('actions')->with('іефегі','Акцію успішно добавлено');
            } else {
               return redirect()->route('actions')->with('error','Знайдені помилки');
            } 

    }
    
    
    public function createActionValue($code_1c,$action_id,$attribute) 
    {
        return ActionValue::create([
            'action_id' => $action_id,
            $attribute  => $code_1c
        ]);
    }
    
    public function actionEditForm(Request $request, $id)
    { 
        if($action = DB::table('action')->where('id', '=', $id)->first()) {
            $action = $this->Conc2tables($action);
            $arrChar = $this->getAllCharacteristic();
            if($action->type==2)
                $action->type = 'Знижка';
            else 
                $action->type = 'Націнка';
            
            return  view('adminPanel.action.edit')->with([
                'originals'  => $action,
                'size'       => $arrChar[0],   
                'color'      => $arrChar[1],
                'product'    => $arrChar[2],
                'collection' => $arrChar[3],
                'users'      => $arrChar[4],
                'brend'      => $arrChar[5],
            ]);

        } else {
            dd('Юзера не знайдено');
        }  
    }
    
    public function updateAction(Request $request, $id) 
    {        
        if($action = Action::find($id)){
            if($request->type == 'Знижка')//удалить эту хрень
                $request->type = 2;
            elseif($request->type == 'Націнка')
                $request->type = 1;
            else
                $request->type=null;
            $validator = Validator::make($request->all(), [
                'type'  => 'required',
                'sum'   => 'required',
            ]); 
            if($validator->fails()) {
                return redirect()->route('action-edit-form',$action->id)->withErrors($validator )->withInput();
            }
            
            $action_value= ActionValue::where('action_id','=', $action->id)->first();
            if($request->type ==1 ) { //якщо націнка
                $rezult = $action->update([
                    'type' => 1,
                    'sign' => 0 ,
                    'sum'  => $request->sum,
                    'active' => ($request->active == '0')? 0 : 1,
                ]); 
                $action = $this->Conc2tables($action);
                DB::table('action_value')->where('action_id','=',$action->id)->delete();
                foreach($request->{$action->attribute} as $value){
                       $this->createActionValue($value,$action->id,$action->attribute);
                }
            }
             elseif($request->type == 2) {
                $rezult = $action->update([
                    'type' => 2,
                    'sign' => $request->sign,
                    'sum'  =>  $request->sum,
                    'active' => ($request->active == '0')? 0 : 1,
                ]); 
                
                $action = $this->Conc2tables($action);
                DB::table('action_value')->where('action_id','=',$action->id)->delete();
                if($request->{$action->attribute})
                    foreach($request->{$action->attribute} as $value){
                           $this->createActionValue($value,$action->id,$action->attribute);
                    }
             }
             else{dd('Не правильный тип');}
             if($rezult)
                return redirect()->route('actions');
             else
                return redirect()->route('action-edit-form',$action->id)->withErrors($rezult);
        } else {
            dd('Акции не знайдено');
        }  
    }
    
    
    
    public function Conc2tables($action)
    {
        if(DB::table('action_value')->where('action_id', '=', $action->id)->first()){
            $action_values=DB::table('action_value')->where('action_id', '=', $action->id)->get();
            
                $attr=[];
                $char = null;
                if(isset($action_values[0]->size))
                    $char = 'size';
                if(isset($action_values[0]->product))
                    $char = 'product';
                if(isset($action_values[0]->color))
                    $char = 'color';
                if(isset($action_values[0]->collection))
                    $char = 'collection';
                if(isset($action_values[0]->user_id))
                    $char = 'user_id';
                if(isset($action_values[0]->brend))
                    $char = 'brend';
            if($char == null){
                DB::table('action_value')->where('action_id', '=', $action->id)->delete();
                return NULL;       
            }
            foreach ($action_values as $action_value) {               
                    $attr[] = $action_value->$char;                
            }
            $action->size=NULL;
            $action->brend=NULL;
            $action->product=NULL;
            $action->color=NULL;
            $action->collection=NULL;
            $action->user_id=NULL;
            $action->$char=$attr;
            $action->attribute=$char;
            
            return $action;
            }
        else DB::table('action')->where('id','=',$action->id)->delete();
    }
    
    public function getAllCharacteristic() 
    {
            $size_char  = Characteristic::where('charact_code_1c', '=', 'ee4e42dc-ce8b-11e5-8584-005056c00008')->first();
            $color_char =  Characteristic::where('charact_code_1c', '=', 'ee4e42da-ce8b-11e5-8584-005056c00008')->first();
            $size  = $size_char->getCharacteristicValue->pluck('value','code_1c')->all();
            $color = $color_char->getCharacteristicValue->pluck('value','code_1c')->all();
            asort($size);
            asort($color);

            $products_char = Products::get();
            $product = $products_char->pluck('name','code_1c')->all();
            asort($product);

            $collections_char = ItemGroup::where('code_1c_parent','!=','00000000-0000-0000-0000-000000000000')->get();
            $collection = $collections_char->pluck('name','items_group_code_1c')->all();
            asort($collection);
            
            $brend_char =ItemGroup::where('code_1c_parent','=','00000000-0000-0000-0000-000000000000')->get();
            $brend = $brend_char->pluck('name','items_group_code_1c')->all();
            asort($brend);
            
            $users_all = User::get();
            $users = $users_all->pluck('email','user_code_1c')->all();
            asort($users);
            
            return [$size,$color,$product,$collection,$users,$brend];
    }
    
    public function realName($char,$attr,$update = null) 
    {
        $allchar = null;
        
        if($attr == 'size' or $attr == 'color')
            foreach($char->$attr as $value)
                $allchar[] = CharacteristicValue::where('code_1c', '=', $value)->value('value');
        
        if($attr == 'product')
            foreach($char->$attr as $value)
                $allchar[] = Products::where('code_1c','=',$value)->value('name');
        
        if($attr == 'collection')
            foreach($char->$attr as $value)
                $allchar[] = ItemGroup::where('items_group_code_1c','=',$value)->value('name');
        
        if($attr == 'brend')
            foreach($char->$attr as $value)
                $allchar[] = ItemGroup::where('items_group_code_1c','=',$value)->value('name');
        
        if($attr == 'user_id')
            foreach($char->$attr as $value)
                $allchar[] = User::where('user_code_1c','=',$value)->value('email');
        
        if(is_array($allchar))
            $char->$attr = implode(" , ", $allchar);
        else
            $char->$attr = $allchar;
        
        return $char;
    }

    public function actionDestroy($id) {
        if(!$action = Action::find($id))
            return response()->json(['status'=>'error']);

        $rezult = $action->delete();
        if($rezult)
            return response()->json(['status'=>'ok']);
        else
            return response()->json(['status'=>'error']);
    }
}
