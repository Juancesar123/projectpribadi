<?php

Route::group(['middleware' => 'web', 'prefix' => 'kabupaten', 'namespace' => 'Modules\Kabupaten\Http\Controllers'], function()
{
    Route::get('/', 'KabupatenController@index');
});
