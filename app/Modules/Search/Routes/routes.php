<?php

Route::group(['middleware' => ['web'],'prefix' => '{locale?}','namespace' =>'App\Modules\Search\Controllers' ], function() {
    Route::get('/search',['uses'=>'SearchController@index'])->name('search');
});

