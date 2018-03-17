<?php

Route::group(['middleware' => ['web'],'prefix' =>  '{locale?}', 'namespace' => 'App\Modules\UserCabinet\Controllers'], function() {

    Route::get('/cabinet/user', ['uses'=>'UserCabinetController@userList'])->name('user-cabinet-list');
    Route::post('/cabinet/user/create', ['uses'=>'UserCabinetController@create'])->name('user-create');
    Route::post('/cabinet/user/showedit', ['uses'=>'UserCabinetController@ActionEditForm'])->name('user-edit-form');
    Route::get('/cabinet/user/add/form/', ['uses'=>'UserCabinetController@UserAddForm'])->name('user-add-form');
    Route::post('/cabinet/user/del/{id?}', ['uses'=>'UserCabinetController@DestroyUser'])->name('user-del');

    Route::get('/cabinet/settings', ['uses'=>'UserSettingsController@UserSettingForm'])->name('user-setting-form');
    Route::post('/cabinet/settings/edit', ['uses'=>'UserSettingsController@UserSetting'])->name('user-setting');

    Route::post('/cabinet/user/edit/{id?}', ['uses'=>'UserCabinetController@ActionEditUser'])->name('user-edit');

    Route::get('/cabinet/user/history/{id?}', ['uses'=>'UserCabinetController@GetOrdersByUser']);

}); 



