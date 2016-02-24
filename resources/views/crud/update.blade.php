<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<form method="POST" action="{{route($table.'.update.api', $data->id)}}">
  <h1>資料表 {{$table}} - 修改</h1>
  <button type="submit" class="btn btn-default">儲存</button>
  <button type="reset" class="btn btn-default">重設</button>
  <a href="{{route($table.'.crud.view')}}" class="btn btn-default">取消</a>
  {!! csrf_field() !!}<br>
  <br><br>
  <table class="table table-bordered table-hover" style="text-align:center;">
    <thead>
      <tr>
        <td>{{$fieldnames[$primary]}}</td>
        @foreach ($fields as $field)
          @if ($field != $primary && $fieldshows[$field])
            <td>{{$fieldnames[$field]}}</td>
          @endif
        @endforeach
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{$data->id}}</td>
        @foreach ($fields as $field)
          @if ($field != $primary && $fieldshows[$field])
            <td><input type="text" name="{{$field}}" value="{{$data->getAttributes()[$field]}}"
            @if ($fieldfixeds[$field])
              readonly="readonly"
            @endif
            ></td>
          @endif
        @endforeach
      </tr>
    </tbody>
  </table>
</form>
