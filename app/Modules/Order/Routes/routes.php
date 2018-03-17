<?php

Route::group(['middleware' => ['web'],'prefix' => '{locale?}', 'namespace' => 'App\Modules\Order\Controllers'], function() {

Route::post('/product/add-pr',['uses'=>'OrderController@AddInCart'])->name('cart-add-pr');
Route::get('/cart',['uses'=>'CartController@CartList'])->name('cart-list');
Route::post('/get-buyer', ['uses'=>'CartController@GetBuyers'])->name('get-buyer');
Route::post('/get-payment-type', ['uses'=>'CartController@GetPaimentType'])->name('get-payment');
Route::post('/get-all-prodict', ['uses'=>'CartController@GetAllProduct'])->name('get-all-product');
Route::post('/delete-prodict/{id}', ['uses'=>'CartController@DeleteProduct'])->name('delete-prodict');
Route::get('/get-product-color-size', ['uses'=>'CartController@GetProductColorSize']);
Route::get('/get-product-color', ['uses'=>'CartController@GetProductByColor']);
Route::get('/get-product-price', ['uses'=>'CartController@GetProductPrice']);
Route::post('/order', ['uses'=>'OrderController@Order'])->name('order-create');
Route::get('/cabinet/history', ['uses'=>'HistoryController@HistoryList']);
Route::post('/updateComment', ['uses'=>'CartController@updateComment']);
Route::post('/setSuctomSize', ['uses'=>'CartController@setCustomSize']);

Route::get('/cabinet/history/detail/{id}', ['uses'=>'HistoryController@HistoryDetail']);

});



 