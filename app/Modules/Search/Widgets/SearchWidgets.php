<?php
namespace App\Modules\Search\Widgets;
use App\Http\Controllers\Controller;
use App\Modules\Widgets\Contract\ContractWidget;
use DB;

class SearchWidgets extends Controller implements ContractWidget
{
    public function execute()
    {
//      dd($this->shop_info);
        $products = DB::table('products')
                      ->get();
       
        return view('Widgets::Search', [ 
            'products' => $products,
        ]);
    }
}
