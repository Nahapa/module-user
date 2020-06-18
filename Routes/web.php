<?php

// Auth::routes();
// Route::get('login/facebook', 'Auth\LoginController@redirectToProviderFacebook')->name('login.facebook');
// Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFacebook')->name('login.facebook.callback');
// Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle')->name('login.google');
// Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle')->name('login.google.callback');


//Route::redirect('/', env('APP_URL') . '/admin');

/////////////////////////////
// Rotas Painel Aplicativo //
/////////////////////////////

Route::group(['prefix' => 'app', 'as' => 'app.'], function () {

    Auth::routes(['register' => false]);

    Route::group(['middleware' => ['auth:app_web', 'tenant', 'bindings']], function () {

        Route::resource('user', 'UserController');

        Route::resource('blocked', 'UserBlockedController')->only(['index', 'update', 'destroy']);

        Route::resource('role', 'RoleController');

        Route::resource('permission', 'PermissionController');

    });


});


/////////////////////////////////
// Rotas Painel Administrativo //
/////////////////////////////////

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Auth::routes(['register' => false]);

    //Rotas Protegidas Autenticação
    Route::group(['middleware' => ['auth:admin_web', 'bindings']], function () {

        Route::resource('user', 'UserController');

        Route::resource('blocked', 'UserBlockedController')->only(['index', 'update', 'destroy']);

        Route::resource('role', 'RoleController');

        Route::resource('permission', 'PermissionController');

    });


});
