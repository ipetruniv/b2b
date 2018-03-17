<?php
namespace App\Modules\Catalog\Traits;
use DB;
use Auth;
trait CatalogTrait {

    /**
     * 
     * вибрати один каталог
     * @return object
     */
    private function itemsGroup() 
    {
        if(Auth::user()->type_price){
            $type = Auth::user()->type_price;
            $products = DB::table('product_price')->where('code_1c_price_type','=',$type)->first();
            $prod = DB::table('products')->where('code_1c','=',$products->code_1c_items)->first();
            $group = DB::table('items_group')
                ->where('code_1c_parent', '!=', '00000000-0000-0000-0000-000000000000')
                ->where('items_group_code_1c','=', $prod->code_1c_items_group)
                ->orderBy('weight')
                ->first();
            $parent = DB::table('items_group')
                ->where('code_1c_parent', '=', '00000000-0000-0000-0000-000000000000')
                ->where('items_group_code_1c','=', $group->code_1c_parent)
                ->orderBy('weight')
                ->first();
            if($parent)
                return $parent;
            else
                $this->getCollection();
        }else
        $this->getCollection();
    }

    public function getCollection(){
        return DB::table('items_group')
            ->where('code_1c_parent', '=', '00000000-0000-0000-0000-000000000000')
            ->orderBy('weight')
            ->first();
    }
    
    /**
     * 
     * @param string $catalog
     * @return object
     */
    private function getCatalogUll($catalog)         
    {
        return DB::table('items_group')->where('url', '=', $catalog)->first();
    }
    
    
    /**
     * 
     * @param string $child_id
     * @return object
     */
    private function getCatalogParent($child_id) 
    {
        return DB::table('items_group')->where('code_1c_parent', '=', $child_id)->pluck('items_group_code_1c');
    }
    
    
    /**
     * Вибирати доступні протукти юзера
     * з категорії
     * 
     * @param string $cat_id
     * @return object
     */
    private function  getProductCategory($cat_id) 
    {
        $products =  DB::table('products as pr')
                     ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items') 
                     ->where('pp.code_1c_price_type','=', Auth::user()->type_price)
                     ->where('pr.code_1c_items_group','=', $cat_id) 
                     ->select('pr.name','pp.price_value', 'pr.id', 'pr.code_1c','pr.code_1c_items_group')
                     ->orderBy('pr.name','ASC')  
                     ->distinct()
                     ->paginate(12);
        return $products;
    }
    
    
     /**
     * Вибирати Всі доступні протукти юзера
     * з всіх  категорій
     * 
     * @param object $cat_ids
     * @return object
     */
    private function getAllProductCategories($cat_ids)
    { 
        $products =  DB::table('products as pr')
                     ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items') 
                     ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                     ->whereIn('pr.code_1c_items_group', $cat_ids)
                     ->select('pr.name','pp.price_value', 'pr.id', 'pr.code_1c','pr.code_1c_items_group')
                     ->orderBy('pr.name','ASC')   
                     ->distinct()
                     ->paginate(12);
        return $products;
    }
    

    /**
     * Дістаємо тип ціни юзера
     * 
     * @return object
     */
    private function getCurrency()
    {
        $currency = DB::table('type_price as tp')
                      ->join('currency as cr', 'tp.code_1c_currency', '=', 'cr.code_1c' )
                      ->where('tp.code_1c','=', Auth::user()->type_price)
                      ->first();
       
        return $currency;
    }
    

   
    
    
    /**
     * Підрахунок к-сті продуктів в категорії
     * 
     * @param string $cat_id
     * @return integer
     */

    private function  getProductCategoryWidget($cat_id) 
    {

        $count =  DB::table('products as pr')
                     ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items') 
                     ->where('pp.code_1c_price_type','=', Auth::user()->type_price)
                     ->where('pr.code_1c_items_group','=', $cat_id) 
                     ->select('pr.name')
                     ->count();
        return $count;
    } 
    
    
    /**
     * Підрахунок к-сті продуктів в категорій
     * 
     * @param string $cat_id
     * @return integer
     */
    
    private function getAllProductCategoriesWidget($cat_ids)
    { 
    
        $count =  DB::table('products as pr')
                     ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items') 
                     ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                     ->whereIn('pr.code_1c_items_group', $cat_ids)
                     ->count();

        return $count;
    }
    
    
    
    /**
     * Витягує наступний продукт
     * 
     * @param string $id
     * @param object $cat
     * @return object
     */
    private function next($weight, $cat)
    {
        return  DB::table('products as pr')
                    ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items')
                    ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                    ->where('pr.code_1c_items_group','=', $cat)
                    ->orderBy('pr.name','ASC') 
                    ->where('pr.weight_sort','>',$weight)
                    ->distinct()
                    ->first();
        
    }
    
     /**
      * Витягує попередній продукт
     * 
     * @param string $id
     * @paramobject $cat
     * @return object
     */
    private function preview($weight, $cat) 
    {
        return DB::table('products as pr')
                ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items')
                ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                ->where('pr.code_1c_items_group','=', $cat)
                ->orderBy('pr.name','DESC') 
                ->where('pr.weight_sort','<',$weight)
                ->distinct()
                ->first();
    }
    
    
    /**
     * Витягуємо товар то ID
     * 
     * @param string $id
     * @return object
     */
    
    private function getProductById($id) 
    {
        return  DB::table('products as pr')
                  ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', Auth::user()->type_price)
                  ->where('pr.id','=', $id)
                  ->select('pr.name','pp.price_value', 'pr.id',
                           'pr.code_1c_items_group', 'pr.weight_sort',
                           'pr.code_1c','pr.code_1c_categories')
                  ->first();
    }

    function getProdById($id,$type_price){
        return  DB::table('products as pr')
                  ->leftJoin('product_price as pp','pr.code_1c', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', $type_price)
                  ->where('pr.id','=', $id)
                  ->select('pr.name','pp.price_value', 'pr.id',
                           'pr.code_1c_items_group', 'pr.weight_sort',
                           'pr.code_1c','pr.code_1c_categories')
                  ->first();
    }
    
    
    
    
//    public function underSize($pr_1c_code)
//    {
//       
//      
//    }
    
    
    
    
    /**
     * Дістає залишки товарів
     * 
     * @param string $product_id
     * @return object
     */
    private function getProductRemains($product_id,$user_price_type = null)
    {
        $remains = DB::table('remains')
                  ->leftjoin('size_color_access as sca','remains.code_1c_characteristic_color_value','=', 'sca.code_1c_characteristic_value')
                  ->leftjoin('characteristic_value as ch','remains.code_1c_characteristic_color_value','=', 'ch.code_1c')
                  ->leftJoin('product_price as pp','remains.code_1c_items_remains', '=', 'pp.code_1c_items')
                  ->where('pp.code_1c_price_type', '=', $user_price_type ?? Auth::user()->type_price)
                  ->where('remains.code_1c_items_remains', '=', $product_id)
                  ->where('pp.code_1c_items','=',$product_id)
                  ->where('sca.not_enabled', '=', 0)
                  ->where('sca.code_1c_prod', '=',$product_id)
                  ->where('remains', '>', 0)
                  ->orderBy('ch.sort_color', 'asc')
                  ->orderBy('remains.name_characteristic_size_value', 'asc')
                  ->distinct()
                  ->get(); 
        return $remains;
    } 
    
    public function underOrder($pr_code)
    {
      
     // $union = DB::table('remains')->where('remains.code_1c_items_remains','=',$pr_code)->get();
      
        return DB::table('size_color_access as sca')
                   ->leftjoin('characteristic_value as ch','sca.code_1c_characteristic_value','=', 'ch.code_1c')
                   ->leftJoin('product_price as pp','sca.code_1c_prod', '=', 'pp.code_1c_items')

                   //->leftJoin('remains','sca.code_1c_prod', '=', 'remains.code_1c_items_remains')
                   ->where('pp.code_1c_price_type', '=', $user_price_type ?? Auth::user()->type_price)
                   ->where('sca.code_1c_prod','=',$pr_code)
                   ->where('sca.not_enabled', '=', 0)  
                  // ->where('remains.code_1c_items_remains','=',$pr_code)
                  // ->where('remains.code_1c_characteristic_size_value', '=', 'ch.code_1c' )
                 //  ->where('sca.code_1c_characteristic', '=', 'ee4e42dc-ce8b-11e5-8584-005056c00008')
                  ->where('sca.code_1c_characteristic', '=', 'ee4e42da-ce8b-11e5-8584-005056c00008')
                
                   // ->where('remains', '>', 0)
                   //  ->orderBy('ch.sort_color', 'asc') 
                  ->orderBy('ch.value', 'asc')
                  ->distinct()
                   ->get();
    }
    
    
    
    public function getSizeUnder($pr_code)
    {
        return DB::table('size_color_access as sca')
                   ->leftjoin('characteristic_value as ch','sca.code_1c_characteristic_value','=', 'ch.code_1c')
                   ->leftJoin('product_price as pp','sca.code_1c_prod', '=', 'pp.code_1c_items')
                   ->where('pp.code_1c_price_type', '=', $user_price_type ?? Auth::user()->type_price)
                   ->where('sca.code_1c_prod','=',$pr_code)
                   ->where('sca.not_enabled', '=', 0)  
                   ->where('sca.code_1c_characteristic', '=', 'ee4e42dc-ce8b-11e5-8584-005056c00008')
                  ->orderBy('ch.value', 'asc')
                  ->distinct()
                   ->get();
    }
    
    
    public function getStore($size,$procent,$color)
    {
//      dd($size);
        return DB::table('remains')
                ->where('name_characteristic_size_value','=', $size->value)
                ->where('name_storage', '=', $procent) 
                ->where('code_1c_items_remains', '=', $size->code_1c_prod)
                ->where('name_characteristic_color_value', '=', $color)
                ->first();
    }
    
    
    public function getUnder($st_100, $st_50, $st_30, $item)
    {
        if(!$st_100 && !$st_50 && !$st_30) {
             return 1;
        }
       
    }
    
    
   
    private function translitName($name)
    {
        $tr = array("А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "E",
            "Ж" => "J",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SCH",
            "Ъ" => "",
            "Ы" => "YI",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "YU",
            "Я" => "YA",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "ж" => "j",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "y",
            "ы" => "yi",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
            "«" => "",
            "»" => "",
            "№" => "",
            "Ӏ" => "",
            "’" => "",
            "ˮ" => "",
            "_" => "-",
            "'" => "",
            "`" => "",
            "^" => "",
            "\." => "",
            "," => "",
            ":" => "",
            "<" => "",
            ">" => "",
            "!" => ""
        );

        foreach ($tr as $ru => $en)  {
            $name = mb_eregi_replace($ru, $en, $name);
        }
        $name = mb_strtolower($name);
        $name = str_replace(' ', '-', $name);
        return $name;
    }
    
    public function BestOffer($productDiscount   = ['many' => 0,'one' => 0],
                                $catalogDiscount = ['many' => 0,'one' => 0],
                                $brendDiscount   = ['many' => 0,'one' => 0],
                                $userDiscount    = ['many' => 0,'one' => 0],
                                $agentDiscount   = ['many' => 0,'one' => 0],
                                $dillerDiscount  = ['many' => 0,'one' => 0],
                                $storageDiscount = ['many' => 0,'one' => 0],
                                $sizeDiscount    = ['many' => 0,'one' => 0]){
//        dd($productDiscount,$catalogDiscount,$brendDiscount,$userDiscount,$agentDiscount,
//                $dillerDiscount,$storageDiscount,$sizeDiscount);
        $discount = $productDiscount['many'] + 
                    $storageDiscount['many'] + 
                    $sizeDiscount['many'] + 
                    $catalogDiscount['many']+
                    $brendDiscount['many']+
                    $userDiscount['many']+
                    $agentDiscount['many']+
                    $dillerDiscount['many'];
        $input = [$discount,$productDiscount['one'],
                    $storageDiscount['one'],
                    $sizeDiscount['one'],
                    $catalogDiscount['one'],
                    $brendDiscount['one'],
                    $userDiscount['one'],
                    $agentDiscount['one'],
                    $dillerDiscount['one']];
        $output = array_filter($input, function($elem) {return $elem !== 0;});
        
        if(empty($output))
            return 0;
        $discount = min($output);
        return $discount;        
    }
    
    public function Markup($size) {
        $markup=DB::table('action_value as av')
                ->leftJoin('action as aa','av.action_id', '=', 'aa.id') 
                ->where('size','=',$size->code_1c)
                ->where('type','=','1')
                ->where('active','=','1')
                ->orderByDesc('sum')
                ->value('sum');
        return $markup;
    }
    
    public function CheckProductPrice($product,$attr) {
        $discounts = DB::table('action_value as av')
                ->leftJoin('action as aa','av.action_id', '=', 'aa.id') 
                ->where($attr,'=',$product->code_1c)
                ->where('type','=','2')
                ->where('sign','=','1')
                ->where('active','=','1')
                ->get();
        
        $total['many'] = 0;
        foreach ($discounts as $value) {
            $total['many'] += $value->sum;
        }
        $total['one'] = DB::table('action_value as av')
                ->leftJoin('action as aa','av.action_id', '=', 'aa.id') 
                ->where($attr,'=',$product->code_1c)
                ->where('type','=','2')
                ->where('sign','=','0')
                ->where('active','=','1')
                ->orderBy('sum')
                ->value('sum');
        $total['one'] += 0;
        return $total;
    }
    
    
    
}  