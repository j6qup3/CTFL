<?php
namespace App\Http\Controllers;
use App\Models\CRUDTable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Auth, Input, View, Redirect, DB;
class CRUDController extends Controller
{
  //資料表
  protected $table;
  //欄位名稱
  protected $fields = [];
  //primary key 欄位名稱
  protected $primary;
  //欄位是否顯示
  protected $fieldshows;
  //顯示的欄位名稱
  protected $fieldnames;
  //欄位能不能更新
  protected $fieldfixeds;
  //建構子
  public function __construct()
  {
    $temp = new CRUDTable();
    $temp->setTable($this->table);
    $this->fields = $temp->getConnection()->getSchemaBuilder()->getColumnListing($this->table);
    //看能不能撈到欄位，不能代表沒此資料表
    if (!$this->fields)
      throw new NotFoundHttpException;
    $this->primary = DB::select(DB::raw('SHOW INDEX FROM '.$this->table.' WHERE Key_name = "PRIMARY"'))[0]->Column_name;
    foreach($this->fields as $field)
    {
      if (!isset($this->fieldshows[$field]))
        $this->fieldshows[$field] = true;
      if (!isset($this->fieldnames[$field]))
        $this->fieldnames[$field] = $field;
      if (!isset($this->fieldfixeds[$field]))
        $this->fieldfixeds[$field] = false;
    }
  }
  public function view()
  {
    if (Input::has('field') && Input::has('exp') && Input::has('value'))
    {
      $datas = new CRUDTable;
      foreach (Input::get('field') as $key => $field)
      {
        $datas = $datas->where($field, Input::get('exp')[$key], Input::get('value')[$key]);
      }
      $datas = $datas->get();
      if (isset($datas[0]))
        return View::make('crud/view', [
          'table' => $this->table,
          'datas' => $datas,
          'primary' => $this->primary,
          'fields' => $this->fields,
          'fieldshows' => $this->fieldshows,
          'fieldnames' => $this->fieldnames,
        ]);
    }
    $datas = CRUDTable::all();
    return View::make('crud/view', [
      'table' => $this->table,
      'datas' => $datas,
      'primary' => $this->primary,
      'fields' => $this->fields,
      'fieldshows' => $this->fieldshows,
      'fieldnames' => $this->fieldnames,
    ]);
  }
  public function create_delete()
  {
    //delete
    if (Input::has('id'))
    {
      foreach (Input::get('id') as $check)
      {
        $data = CRUDTable::find($check);
        $data->delete();
      }
      return Redirect::back();
    }
    $flag = 1;
    foreach ($this->fields as $field)
      if ($field != $this->primary && $this->fieldshows[$field] && !Input::has($field))
        $flag = 0;
    if ($flag)
    {
      $data = new CRUDTable;
      foreach ($this->fields as $field)
        if (Input::has($field))
          $data->setAttribute($field, Input::get($field));
        else
          $data->setAttribute($field, NULL);
      $data->save();
      return Redirect::back();
    }
    throw new NotFoundHttpException;
  }
  public function update_view($id)
  {
    if ($id)
    {
      $data = CRUDTable::find($id);
      return View::make('crud.update_view', [
        'table' => $this->table,
        'data' => $data,
        'primary' => $this->primary,
        'fields' => $this->fields,
        'fieldshows' => $this->fieldshows,
        'fieldnames' => $this->fieldnames,
        'fieldfixeds' => $this->fieldfixeds,
      ]);
    }
    throw new NotFoundHttpException;
  }
  public function update_api($id)
  {
    $flag = 1;
    foreach ($this->fields as $field)
      if ($field != $this->primary && $this->fieldshows[$field] && !Input::has($field))
        $flag = 0;
    if ($id && $flag)
    {
      $data = CRUDTable::find($id);
      foreach ($this->fields as $field)
        if ($field != $this->primary)
          $data->setAttribute($field, Input::get($field));
      $data->save();
      return Redirect::route('crud.view', $this->table);
    }
    throw new NotFoundHttpException;
  }
}
