<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\User;


Route::get('/create-preview',function() {
    $id = DB::table('preview_last')->pluck('id')->first();
    $curid = (int)$id + 1;
    $img_code_1c = DB::table('products')->where('id', '=', $curid)->pluck('code_1c')->first();
    try{
        $image_url = $_SERVER['DOCUMENT_ROOT'] . "/public/images/products/$img_code_1c/$img_code_1c"."_0".".jpg";
        if(file_exists($image_url)) {
            echo $image_url;

            // Set a maximum height and width
            $width = 300;
            $height = 500;

            // Get new dimensions
            list($width_orig, $height_orig) = getimagesize($image_url);

            $ratio_orig = $width_orig/$height_orig;

            if ($width/$height > $ratio_orig) {
                $width = $height*$ratio_orig;
            } else {
                $height = $width/$ratio_orig;
            }

            // Resample
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromjpeg($image_url);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

            $preview_url = getcwd() . "/images/products/preview/$img_code_1c/$img_code_1c" . "_0" . ".jpg";

            if(!file_exists($preview_url)){

                mkdir($_SERVER['DOCUMENT_ROOT']."/public/images/products/preview/$img_code_1c", 0777);

                imagejpeg($image_p, $preview_url);

                chmod($preview_url, 0777);
                chmod($_SERVER['DOCUMENT_ROOT']."/public/images/products/preview/$img_code_1c", 0777);
            }
        }
        DB::table('preview_last')->update(['id'=>$curid]);
    }
    catch(Exception $e){
        print_r($e);
    }
});

Route::group(['middleware' => ['web']], function() {
    Route::get('/setlocale/{locale}', function ($locale) {
        if (in_array($locale, \Config::get('app.locales'))) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            if (Auth::check()) {
                $user = Auth::user();
                $user->language = $locale;
                $user->save();
            }
        }
        $url   = url()->previous();
        $url_explode = explode("/",$url);
        $url_explode[3] = $locale;
        $redir = implode('/',$url_explode);

        return redirect()->to($redir);
//        return  redirect('/'.$locale);
    });
});


Route::post('/custom-register/user', 'Auth\CustomAuthController@register')->name('custom-register');
Route::post('/custom-login/user', 'Auth\CustomAuthController@login')->name('custom-login');


//RESET PASSWORD
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request-post');

Route::group([['middleware' => ['web']],'prefix' => '{locale?}'], function() {
    Auth::routes();
});

Route::get('/{locale}','Home\IndexController@Home');

Route::get('/',function() {
    if (Auth::check()) {
        $locale = Auth::user()->language;
//        dd($locale);
        return redirect('/setlocale/'.$locale);
    }
    else if ($locale = App::getLocale()) {
        return redirect('/'.$locale);
    } else {
        return redirect('/en');
    }

});

Route::group(['prefix'=>'admin'], function() { 
    Route::get('/dashboard','Admin\AdminController@Dashboard')->name('dashboard');
    Route::get('/user/edit/{id}', 'Admin\AdminController@userEditForm')->where(['id'=>'[0-9]+'])->name('users-edit-form');
    Route::post('/user/edits-confirm/{id}', 'Admin\AdminController@ActionEditUser')->name('user-edit');
    Route::post('/user/destroy/{id}', 'Admin\AdminController@userDestroy')->name('user-destroy');
    
    Route::get('/actions','Admin\ActionController@Actions')->name('actions');
    Route::get('/actions/add', 'Admin\ActionController@FormAdd')->name('users-add-form');
    Route::post('/actions/create', 'Admin\ActionController@actionCreate')->name('actions-create');
    Route::get('/actions/edit/{id}', 'Admin\ActionController@actionEditForm')->name('action-edit-form');
    Route::post('/actions/edits-confirm/{id}', 'Admin\ActionController@updateAction')->name('actions-update');
    Route::post('/action/destroy/{id}', 'Admin\ActionController@actionDestroy')->name('action-destroy');
    Route::post('/user/destroy/{id}', 'Admin\AdminController@userDestroy')->name('user-destroy');
    
});






