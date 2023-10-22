<?php

Route::group([
    'prefix' => 'v1',
], function () {
    $options = [
        'except' => [
            'create',
            'edit',
            'delete'
        ]
    ];

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');


    Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');
    Route::resource('rules', 'RulesController', ['only' => ['index']], $options);
    Route::resource('devices', 'DevicesController', $options);
    Route::resource('roles', 'RolesController', $options);
    Route::resource('users', 'UsersController', $options);
    Route::resource('categories', 'CategoriesController', $options);

    Route::delete('devices', 'DevicesController@destroy', $options);


});