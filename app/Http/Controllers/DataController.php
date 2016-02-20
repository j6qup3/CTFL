<?php
namespace App\Http\Controllers;

class DataController extends CRUDController
{
  //資料表
  protected $table = 'datas';
  //欄位是否顯示
  protected $fieldshows = [];
  //顯示的欄位名稱
  protected $fieldnames = ['a' => 'A', 'b' => 'B', 'c' => 'C'];
  //欄位能不能更新
  protected $fieldfixeds = [];
}
