<?php

Route::group(['middleware' => 'web', 'prefix' => 'provinsi', 'namespace' => 'Modules\Provinsi\Http\Controllers'], function()
{
    Route::get('/', 'ProvinsiController@provinsi');
});
Route::group(['middleware' => 'web', 'prefix' => 'provinsi', 'namespace' => 'Modules\Provinsi\Http\Controllers'], function()
{
    Route::resource('api', 'ProvinsiController');
});