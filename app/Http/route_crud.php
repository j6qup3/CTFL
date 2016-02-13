<?php
Route::group(['prefix' => 'crud', 'middleware' => 'auth'], function()
{
  //一一設定 (第二個參數陣列內可填 'as' => 'XX')
  Route::get('123', function()
  {
    return Redirect::route('crud.view', 'users');
  });

  Route::group(['prefix' => '{table}'], function()
  {
    //主頁面 & R
    Route::get('/', ['as' => 'crud.view', 'uses' => 'CRUDController@view']);
    //C & D
    Route::post('/', ['as' => 'crud.api', 'uses' => 'CRUDController@create_delete']);
    //U
    Route::get('{id}', ['as' => 'update.view', 'uses' => 'CRUDController@update_view'])->where('id', '[0-9]+');
    Route::post('{id}', ['as' => 'update.api', 'uses' => 'CRUDController@update_api'])->where('id', '[0-9]+');
  });
});
