<?php
Route::group(['prefix' => 'crud', 'middleware' => 'auth'], function()
{
  Route::group(['prefix' => 'datas'], function()
  {
    //主頁面 & R
    Route::get('/', ['as' => 'datas.crud.view', 'uses' => 'DataController@view']);
    //C & D
    Route::post('/', ['as' => 'datas.crud.api', 'uses' => 'DataController@create_delete']);
    //U
    Route::get('{id}', ['as' => 'datas.update.view', 'uses' => 'DataController@update_view'])->where('id', '[0-9]+');
    Route::post('{id}', ['as' => 'datas.update.api', 'uses' => 'DataController@update_api'])->where('id', '[0-9]+');
  });
  Route::group(['prefix' => 'users'], function()
  {
    $table = 'users';
    $controller = 'User';
    //主頁面 & R
    Route::get('/', ['as' => $table.'.crud.view', 'uses' => $controller.'Controller@view']);
    //C & D
    Route::post('/', ['as' => $table.'.crud.api', 'uses' => $controller.'Controller@create_delete']);
    //U
    Route::get('{id}', ['as' => $table.'.update.view', 'uses' => $controller.'Controller@update_view'])->where('id', '[0-9]+');
    Route::post('{id}', ['as' => $table.'.update.api', 'uses' => $controller.'Controller@update_api'])->where('id', '[0-9]+');
  });
});
