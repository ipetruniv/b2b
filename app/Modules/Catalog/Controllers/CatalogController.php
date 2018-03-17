<?php

namespace App\Modules\Catalog\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Catalog\Traits\CatalogTrait;
use App\Modules\UserCabinet\Traits\UserTrait;
use Validator;
use App\Models\Products;
use App\Models\ItemGroup;
use App\Models\User;
use App;
use Auth;
use DB;
use Session;

class CatalogController extends Controller
{
    use CatalogTrait;
    use UserTrait;

    public $typePrice;
    public $buyer;
    public $users;
    public function __construct()
    {
        $this->middleware('IsAdmin');
        $this->middleware('auth');
        $this->buyer = $this->getBuyer();

        if(Auth::user()->type_price) {
          $this->typePrice = $this->getCurrency();
        }
        // dd($this->typePrice);
        if(!$this->typePrice) { 
           die('The price type is not defined for this user');
        } 
    }

    function getBuyer(){
      $buyer = Session::get('buyer');
      if(is_null($buyer)){
        $buyer = Auth::user()->getFirstChild(true) ?? Auth::user();
        // dd($buyer);
        Session::put('buyer',$buyer);
      }
      return $buyer;
    }

    /*
     * По замовчуванню вибираємо каталог з найменшим weight 
     * і витягуємо всі по ньому продукти
     */

    public function catalogListAction()
    { 
       
        $catalogs = $this->itemsGroup();

        $url = App::getLocale()."/catalog/".$catalogs->url;

        return redirect($url);
           
    }

    public function getProd($cat_id, $offset = 0)
    {
      $products =  Products::leftJoin('product_price as pp','products.code_1c', '=', 'pp.code_1c_items')
                   ->where('pp.code_1c_price_type','=', $this->buyer->type_price)
                   ->where('products.code_1c_items_group','=', $cat_id)
                   ->select('products.name','pp.price_value', 'products.id', 'products.code_1c','products.code_1c_items_group')
                   ->orderBy('products.name','ASC')
                   ->distinct()
                    ->offset($offset)
                    ->limit(10)
                    ->get();
      return $products;
    }
    
    
    /**
     * Вивід товарів по категоріях
     * 
     * 
     * @param string $parrent - перший рівень
     * @param string $children - другий рівень
     * @return object
     */
    public function GetCatalogAction($lang, $parrent, $children = null)
        { 

            if( !$catalogs = $this->getCatalogUll($parrent)) {
                  return redirect()->route('catalog-list')->with('status', __('messages.CATALOG_NOT_FOUND'));
            }

            // другий рівень
            if($parrent != null && $children == null) {
             
                $get_cat =  $this->getCatalogParent($catalogs->items_group_code_1c);
                if($get_cat) { 
                    $products = $this->getProd($get_cat);
                }
            }
    //        dd($products);
           
            // третій рівень
            if($parrent != NULL && $children != null) 
            {  
                $children = $this->getCatalogUll($children);
                if($children) { 
                    $products = $this->getProd($children->items_group_code_1c); 
                } else {
                   return redirect(App::getLocale().'catalog-list')->with('status', __('messages.CATALOG_NOT_FOUND'));
                } 
            }
            
            $discount = $this->discount($products, 0, 0, 1,$catalogs);
            foreach($products as $product){
                $bestDiscount = $this->BestOffer($product->productDiscount,$product->catalogDiscount,$product->brendDiscount,$discount[3],$discount[4],$discount[5]);
                if($bestDiscount == 0)
                    $product->new_price = $product->price_value;
                else
                    $product->new_price = ceil ($product->price_value - ($product->price_value / 100 * (-$bestDiscount)));
            }
            
        $this->getUsers();

        return view('Catalog::list')->with('catalogs',   $catalogs)
                                     ->with('products',  $products)
                                     ->with('children',  $children ?? null)
                                     ->with('typePrice', $this->typePrice)
                                     ->with('users',     $this->users)   
                                     ->with('buyer',     $this->buyer);   
    }



    function setUserPrice(Request $request)
    {
      $user     = User::where('user_code_1c',$request->user)->first();
      Session::put('buyer', $user);
      return response()->json(['type'=>$user]);
    }

    public function getUserPrice($typePrice)
    {
      $currency = DB::table('type_price as tp')
                    ->join('currency as cr', 'tp.code_1c_currency', '=', 'cr.code_1c' )
                    ->where('tp.code_1c','=', $typePrice)
                    ->first();
      return $currency;
    }





    /**
     * Детальна сторінка продукта
     *
     * @param parent, id
     * @return object
     */
    public function GetProductActionMain($lang, $parrent, $id)
    {


        $data = [];
         
        if(!$catalogs = $this->getCatalogUll($parrent)) {
            die('directory is not available');
        }
  
        $get_cat  =  $this->getCatalogParent($catalogs->items_group_code_1c);

        $product  = $this->getProdById($id,$this->buyer->type_price);
        if(!$product) {
            die('The product is not available for you');
        }
        
        $storages = $this->underOrder($product->code_1c); 
        
        $sizes = $this->getSizeUnder($product->code_1c);
       
        if(!$storages) {
            die('Not in stock');
        }
//        dd($sizes);
        $discount = $this->discount($product,$storages,$sizes);
        foreach ($storages as $item) {
            foreach($sizes as $size) {
               $markup = $this->Markup($size);
               if($size->value == 'Ind')
                $bestDiscount = $this->BestOffer($discount[0],$discount[1],$discount[2],$discount[3],$discount[4],$discount[5],$item->discount);
               else
                $bestDiscount = $this->BestOffer($discount[0],$discount[1],$discount[2],$discount[3],$discount[4],$discount[5],$item->discount,$size->discount);
                $price = ceil(($product->price_value*($markup/100+1)));
                $data[$item->value][$size->value] = [
                  'storage_100'=> $st_100 = $this->getStore($size, '100%', $item->value),
                  'storage_50' => $st_50  = $this->getStore($size, '50%',  $item->value),
                  'storage_30' => $st_30  = $this->getStore($size, '30%',  $item->value),
//                  'storage_100'=> $st_100 = $this->getStore($size, '100%'),
//                  'storage_50' => $st_50 = $this->getStore($size, '50%'),
//                  'storage_30' => $st_30 = $this->getStore($size, '30%'),
                  'under'      => $this->getUnder($st_100, $st_50, $st_30, $item),
                  'color'      => $item->code_1c_characteristic_value,
                  'size'       => $size->code_1c_characteristic_value,
                  'price'      => ceil( $price - ($price / 100 * (-$bestDiscount))),
                  'old_price'  => $price,
                  'discount'   => $bestDiscount,
            ];   
            }
        }       
        
        $next     = $this->next($product->weight_sort, $product->code_1c_items_group);
        $preview  = $this->preview($product->weight_sort,  $product->code_1c_items_group );
        
        $photo_1  = $this->existImagesProduct($product->code_1c,$product->code_1c.'_0');
        $photo_2  = $this->existImagesProduct($product->code_1c,$product->code_1c.'_1');
        $photo_3  = $this->existImagesProduct($product->code_1c,$product->code_1c.'_3');

        $this->getUsers();

        return view('Catalog::detail')->with('product',   $product)
                                      ->with('next',      $next)
                                      ->with('typePrice', $this->typePrice)
                                      ->with('parrent',   $parrent)
                                      ->with('preview',   $preview)
                                      ->with('storages',  $storages)
                                      ->with('data',      $data)
                                      ->with('catalogs',  $catalogs)
                                      ->with('photo_1',   $photo_1)
                                      ->with('photo_2',   $photo_2)
                                      ->with('photo_3',   $photo_3)
                                      ->with('users',     $this->users)
                                      ->with('buyer',     $this->buyer);
    }

    function getUsers(){

      $userUser   = $this->userIs();
      $users_data = $this->switcType($userUser);

      if($userUser == 'Diller') {
          $this->users =  $this->getUserDiller();
      } 
      if($userUser == 'Bayer') {
          $this->users =  $this->getUserInfo();
      } 
       if($userUser == 'Agent') {
          $this->users =  $this->getUserAgent();
      } 

    }
    
    public function discount($product, $storages =0, $sizes =0 ,$filter =0, $catalog =0) {
        if(!$filter){
            $productDiscount = $this->CheckProductPrice($product,'product');

            foreach($storages as $storage)
                $storage->discount = $this->CheckProductPrice($storage,'color');

            foreach($sizes as $size)
                $size->discount = $this->CheckProductPrice($size,'size');

            $catalog = DB::table('items_group')->where('items_group_code_1c','=',$product->code_1c_items_group)->first();
            $catalog->code_1c = $catalog->items_group_code_1c;
            $catalogDiscount = $this->CheckProductPrice($catalog,'collection');
            $catalog->code_1c = $catalog->code_1c_parent;
            $brendDiscount = $this->CheckProductPrice($catalog,'brend');
        }
        else{
            foreach ($product as $prod) {
                $productDiscount = $this->CheckProductPrice($prod,'product');
                $prod->productDiscount = $productDiscount;
                $catalog = DB::table('items_group')->where('items_group_code_1c','=',$prod->code_1c_items_group)->first();
                $catalog->code_1c = $catalog->items_group_code_1c;
                $prod->catalogDiscount = $this->CheckProductPrice($catalog,'collection');
                $catalog->code_1c = $catalog->code_1c_parent;
                $prod->brendDiscount = $this->CheckProductPrice($catalog,'brend');
                
            }
            $productDiscount = 0;
            $catalogDiscount = 0;
            $brendDiscount = 0;
        }
        
            
        $user = Auth::user();
        $user->code_1c =$user->user_code_1c;
        $userDiscount = $this->CheckProductPrice($user,'user_id');
        
        if($user->agent_id != 0)
            $agentDiscount = ['many'=> 0,'one'=>0];
        else{
            $user->code_1c = $user->agent_id;
            $agentDiscount = $this->CheckProductPrice($user,'user_id');   
        }
        
        if($user->diller_id == 0)
            $dillerDiscount = ['many'=> 0,'one'=>0];
        else{
            $user->code_1c = $user->diller_id;
            $dillerDiscount = $this->CheckProductPrice($user,'user_id');   
        }
        return [$productDiscount,$catalogDiscount,$brendDiscount,$userDiscount,$agentDiscount,$dillerDiscount];
    }
            
    public function existImagesProduct($dir,$file_name) 
    {
        $url = "images/products/{$dir}/{$file_name}.jpg";
        if(file_exists($url)) {
            return $file_name;
        } else {
            return false;
        }
    }

    public function loadMoreProduct ($lang, $parrent, $page, $children = null)
    {
        $catalogs = $this->getCatalogUll($parrent);
        $cat =  $this->getCatalogParent($catalogs->items_group_code_1c);
        $products =  $this->getProd($cat, $page);

        if($parrent != NULL && $children != null) {
            $children = $this->getCatalogUll($children);
            if ($children) {
                $products = $this->getProd($children->items_group_code_1c, $page);
            }
        }

        $data = view('Catalog::load-more')
            ->with('catalogs',   $catalogs)
            ->with('products',  $products)
            ->with('typePrice', $this->typePrice)->render();


        return response()->json(array('success' => true, 'html'=>$data));
    }

}
