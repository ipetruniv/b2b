<?php

namespace App\Modules\Catalog\Widgets;
use App\Modules\Widgets\Contract\ContractWidget;
use App\Http\Controllers\Controller;
use App\Modules\Catalog\Traits\CatalogTrait;
use Illuminate\Support\Facades\Cache;
use Auth;
use DB;

class CatalogWidgets extends Controller implements ContractWidget
{
    use CatalogTrait;
  
   /**
    * Виджет вивода каталога в меню
    * 
    * @return object
    */

    public function execute()
    {  
        if (Cache::has('catalog'.Auth::user()->id)) {
            return  View('Widgets::Catalog', [
                'catalogs'  =>  Cache::get('catalog'.Auth::user()->id),
            ]);
        } else {
            $result = DB::table('items_group')->orderBy('weight')->get()->toArray();
            $catalogs = $this->buildTree($result);
           // dd($catalogs);
            Cache::put('catalog'.Auth::user()->id, $catalogs, 10);
            return  View('Widgets::Catalog', [
                'catalogs'  => $catalogs,
            ]);
        }
    }
    
    /**
     * 
     * @param array $data
     * @return array
     */ 

    public  function buildTree ($data)
    {
        $result = [];
        if ( is_array($data) ) {
            $items_count = count($data);
            for ($i = 0; $i < $items_count; $i ++) {
                $item = $data[$i];
                if ($item->code_1c_parent == '00000000-0000-0000-0000-000000000000') {
                    $cats_id = $this->getCatalogParent($item->items_group_code_1c);
                    $children      = $this->getChild($data, $item->items_group_code_1c);
                    $item->child   = $children;
                    $result[]      = $item; 
                    $item->counts  = $this->getAllProductCategoriesWidget($cats_id);
                }
            }

        }
        return ( isset($result) ) ? $result : false;
    }


    public function getChild ($array, $id) 
    {
        $count = count($array);
        for ( $i = 0; $i < $count; $i ++ ) {
            $item = $array[$i];
            if ( $item->code_1c_parent == $id ) {
                $children      = $this->getChild( $array, $item->items_group_code_1c );
                $item->child = $children;
                $child_array[] = $item;
                $item->counts  = $this->getProductCategoryWidget($item->items_group_code_1c);
            }
        }
        return (isset( $child_array )) ? $child_array : false;
    }

    
}