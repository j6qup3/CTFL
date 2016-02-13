<?php
namespace App\Http\Controllers;
use App\Models\CRUDTable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Auth, Input, View, Redirect, DB;
class CRUDController extends Controller
{
  //欄位名稱
  protected $fields = array();
  //primary key 欄位名稱
  protected $primary;
  //欄位是否顯示
  protected $fieldshows;
  //顯示的欄位名稱
  protected $fieldnames;
  //欄位能不能更新
  protected $fieldfixeds;
  //改關聯資料表並更新關聯
  public function changeTable($table)
  {
    $temp = new CRUDTable();
    $temp->setTable($table);
    $this->fields = $temp->getConnection()->getSchemaBuilder()->getColumnListing($table);
    //看能不能撈到欄位，不能代表沒此資料表
    if (!$this->fields)
      return 1;
    $this->primary = DB::select(DB::raw('SHOW INDEX FROM '.$table.' WHERE Key_name = "PRIMARY"'))[0]->Column_name;
    foreach($this->fields as $field)
    {
      $this->fieldshows[$field] = true;
      $this->fieldnames[$field] = $field;
      $this->fieldfixeds[$field] = false;
    }
    //自定義區塊
    if ($table == 'users')
    {
      $this->fieldshows['password'] = false;

      $this->fieldnames['account'] = '帳號';

      $this->fieldnames['remember_token'] = '記住我';
      $this->fieldfixeds['remember_token'] = true;
    }
    if ($table == 'comments')
    {
      $this->fieldshows['time'] = false;
    }
  }
  public function view($table)
  {
    if(self::changeTable($table))
      throw new NotFoundHttpException;

    if (Input::has('field') && Input::has('exp') && Input::has('value'))
    {
      $datas = CRUDTable::where(Input::get('field'), Input::get('exp'), Input::get('value'))->get();
      if (isset($datas[0]))
        return View::make('crud/view', [
          'table' => $table,
          'datas' => $datas,
          'primary' => $this->primary,
          'fields' => $this->fields,
          'fieldshows' => $this->fieldshows,
          'fieldnames' => $this->fieldnames,
        ]);
    }
    $datas = CRUDTable::all();
    return View::make('crud/view', [
      'table' => $table,
      'datas' => $datas,
      'primary' => $this->primary,
      'fields' => $this->fields,
      'fieldshows' => $this->fieldshows,
      'fieldnames' => $this->fieldnames,
    ]);
  }
  public function create_delete($table)
  {
    if(self::changeTable($table))
      throw new NotFoundHttpException;

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
  public function update_view($table, $id)
  {
    if ($id)
    {
      if(self::changeTable($table))
        throw new NotFoundHttpException;

      $data = CRUDTable::find($id);
      return View::make('crud.update_view', [
        'table' => $table,
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
  public function update_api($table, $id)
  {
    if(self::changeTable($table))
      throw new NotFoundHttpException;

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
      return Redirect::route('crud.view', $table);
    }
    throw new NotFoundHttpException;
  }
}
