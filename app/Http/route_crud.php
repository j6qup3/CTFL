<?php
Route::group(['prefix' => 'crud', 'middleware' => 'auth'], function()
{
  Route::group(['prefix' => 'datas'], function()
  {
    //主頁面 & R
    Route::get('/', ['as' => 'crud.view', 'uses' => 'DataController@view']);
    //C & D
    Route::post('/', ['as' => 'crud.api', 'uses' => 'DataController@create_delete']);
    //U
    Route::get('{id}', ['as' => 'update.view', 'uses' => 'DataController@update_view'])->where('id', '[0-9]+');
    Route::post('{id}', ['as' => 'update.api', 'uses' => 'DataController@update_api'])->where('id', '[0-9]+');
  });
});
