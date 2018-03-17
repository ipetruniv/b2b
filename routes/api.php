<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['api']], function () {
    /*user*/
    Route::get('/get-user', 'API\ApiUser@getUserAction');
    Route::post('/add-user', 'API\ApiUser@InsertNewUserAction')->middleware('debugapi');
    Route::post('/edit-user', 'API\ApiUser@EditUserAction')->middleware('debugapi');
    /*user*/
     

    Route::post('/add-curr', 'API\ApiCurrency@AddCurrency')->middleware('debugapi');
    
    Route::post('/add-price_type', 'API\ApiTypePrce@AddTypePrce')->middleware('debugapi');

    Route::post('/add-characteristic', 'API\ApiCharacteristic@AddCharacteristic')->middleware('debugapi');

    Route::post('/add-characteristic_value', 'API\ApiCharacteristicValue@AddCharacteristicValue')->middleware('debugapi');
  
    Route::post('/add-Item_specifications', 'API\ApiItemSpecifications@AddItemSpecifications')->middleware('debugapi');

    Route::post('/add-сategories', 'API\ApiCategories@AddCategories')->middleware('debugapi');
  
    Route::post('/add-items_group', 'API\ApiItemGroup@AddItemGroup')->middleware('debugapi');
    
    Route::post('/add-item_specifications_value', 'API\ApiItemSpVal@AddSpVal')->middleware('debugapi');
    
    Route::post('/add-items', 'API\ApiProduct@AddProduct')->middleware('debugapi');
    
    Route::post('/add-item_price', 'API\ApiProductPrice@AddProductPrice')->middleware('debugapi');
    
    Route::post('/add-size_color_access', 'API\ApiSizeColorAccess@AddSizeColor')->middleware('debugapi');
    
    Route::post('/add-storages', 'API\ApiStorages@AddStorages')->middleware('debugapi');     //склади
    
    Route::post('/add-remains_items', 'API\ApiRemains@AddRemains')->middleware('debugapi'); // залишки
    
    
    
    Route::get('/get-orders', 'API\ApiOrder@OrderList')->middleware('debugapi');
    
    Route::post('/add-order_status', 'API\ApiOrder@addOrderStatus')->middleware('debugapi'); // статуси замовлення
 
    Route::post('/upd-order', 'API\ApiOrder@UpdateOrders')->middleware('debugapi');
    
    Route::get('getfile/{file}',function($file){

        $file = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/apilog/'.$file));

        header("Content-type: text/xml");
        echo $file->xml;
        
    });
    
    
});

