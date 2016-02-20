<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<span class="dropdown">
  <a class="btn btn-default" data-toggle="dropdown" href="#">{{$table}} <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="{{route('crud.view', 'datas')}}">datas</a></li>
    <li><a href="{{route('crud.view', 'users')}}">users</a></li>
    <li><a href="{{route('crud.view', 'comments')}}">comments</a></li>
    <li><a href="{{route('crud.view', 'texts')}}">texts</a></li>
  </ul>
</span>
<h1>資料表 {{$table}}</h1>
<br>
<a class="btn btn-default" onClick="$('.slide').slideToggle()">條件區 <span class="caret"></span></a>
<div class="slide" style="display: none;">
  <form method="GET" action="{{route('crud.view')}}">
    <br>
    欄位：<select type="text" name="_field">
      <option value="{{$primary}}">{{$fieldnames[$primary]}}</option>
      @foreach ($fields as $field)
        @if ($fieldshows[$field] && $field != $primary)
          <option value="{{$field}}">{{$fieldnames[$field]}}</option>
        @endif
      @endforeach
    </select>
    <select type="text" name="order">
      <option value="ASC">由低到高</option>
      <option value="DESC">由高到低</option>
    </select><br>
    <span class="last">
      欄位：<select type="text" name="field[]">
        @foreach ($fields as $field)
          @if ($fieldshows[$field])
            <option value="{{$field}}">{{$fieldnames[$field]}}</option>
          @endif
        @endforeach
      </select>
      <select type="text" name="exp[]">
        <option>></option>
        <option selected>=</option>
        <option><</option>
      </select>
      值：<input type="text" name="value[]">
    </span>
    <a class="btn btn-default" href="#" onclick="$('.last:last').after('<br>', $('.last:last').clone()); $('.last:last>input').val('')">新增條件</a><br>
    <br>
    <input type="submit" class="btn btn-default" value="篩選">
  </form>
</div>
<br><br>
<table class="table table-bordered table-hover" style="text-align:center;">
  <thead>
    <form method="POST" action="{{route('crud.api')}}">
      {!! csrf_field() !!}
      <tr>
        <td style="vertical-align:middle;">{{$fieldnames[$primary]}}</td>
        <td><input type="submit" class="btn btn-default form-control" value="刪除"></td>
        @foreach ($fields as $field)
          @if ($field != $primary && $fieldshows[$field])
            <td style="vertical-align:middle;">{{$fieldnames[$field]}}</td>
          @endif
        @endforeach
        <td style="vertical-align:middle;">更新</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($datas as $data)
        <tr>
          <td style="vertical-align:middle;">{{$data->getAttributes()[$primary]}}</td>
          <td><input class="form-control" type="checkbox" name="id[]" value="{{$data->getAttributes()[$primary]}}"></td>
          @foreach ($fields as $field)
            @if ($field != $primary && $fieldshows[$field])
              <td style="vertical-align:middle;">{{$data->getAttributes()[$field]}}</td>
            @endif
          @endforeach
          <td>
          <a class="btn btn-default form-control" href="{{route('update.view', $data->getAttributes()[$primary])}}">修改</a></td>
        </tr>
      @endforeach
    </form>
    <form method="POST" action="{{route('crud.api')}}">
      {!! csrf_field() !!}
      <tr>
        <td></td>
        <td></td>
        @foreach ($fields as $field)
          @if ($field != $primary && $fieldshows[$field])
            <td><input class="form-control" type="text" name="{{$field}}"></td>
          @endif
        @endforeach
        <td><input type="submit" class="btn btn-default form-control" value="新增"></td>
      </tr>
    </form>
  </tbody>
</table>
