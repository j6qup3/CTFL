<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CRUDTable extends Model
{
  //$table 作為非 static 變數已經被 Model 定義過了
  protected static $_table = 'datas';
  public $timestamps = false;


  public function setTable($table)
  {
    static::$_table = $table;
  }

  public function getTable()
  {
    return static::$_table;
  }
}
