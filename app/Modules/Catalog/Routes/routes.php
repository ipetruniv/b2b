<?php

Route::group(['middleware' => ['web'],'prefix' => '{locale?}', 'namespace' => 'App\Modules\Catalog\Controllers'], function() {
    Route::get('/catalog', ['uses'=>'CatalogController@catalogListAction'])->name('catalog-list');
    Route::get('/catalog/{parrent?}/{children?}', ['uses'=>'CatalogController@GetCatalogAction'])->name('catalog');
    Route::get('/catalog/{parrent?}/product/{id}', ['uses'=>'CatalogController@GetProductActionMain'])->name('product-item-main');
    Route::post('/catalog/{parrent?}/load-more-product/{page?}/{children?}', ['uses'=>'CatalogController@loadMoreProduct'])->name('load-more-product');


    // Route::get('/agent/buyer/{id}', ['uses'=>'CatalogController@GetBuyer'])->name('agent-buyer');
  //  Route::get('/buyer/agent/{id}', ['uses'=>'CatalogController@GetAgent'])->name('buyer-agent');


});
Route::post('/setUserPrice',   'App\Modules\Catalog\Controllers\CatalogController@setUserPrice')->name('setUserPrice');

