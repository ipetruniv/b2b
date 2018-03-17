<?php

namespace App\Modules\Search\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Modules\Catalog\Traits\CatalogTrait;
use Validator;
use Auth;
use DB;
use App;


class SearchController extends Controller {

    
    use CatalogTrait;
    public $typePrice;
    
    public function __construct() 
    {
        $this->middleware('auth');
        if(Auth::user()->type_price) {
          $this->typePrice = $this->getCurrency();
        }
        if(!$this->typePrice) { 
           die('The price type is not defined for this user');
        } 
      
    }
    public function index(Request $request)
    {
        if($request->product) {            
            $products = (new Products())->getProductByNames($request->product);
//            dd($products);
            return view('Search::results')->with('products',  $products)
                                          ->with('typePrice',$this->typePrice);
        }
        return redirect($request->server('HTTP_REFERER'));        
    }
   

}

