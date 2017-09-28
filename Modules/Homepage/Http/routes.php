<?php

Route::group(['middleware' => 'web', 'namespace' => 'Modules\Homepage\Http\Controllers'], function()
{
    Route::get('/', 'HomepageController@index');
});
