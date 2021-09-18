<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'settings', 'as' => 'settings.'], function($router) {
    $router->get('/', 'SettingsController@public')->name('public');
});
