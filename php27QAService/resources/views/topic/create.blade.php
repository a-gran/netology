@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="{{ route('topic.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="topic" class="col-sm-3 control-label">Название темы</label>
              <div class="col-sm-9">
                <input type="text" name="topic" required class="form-control" id="topic">
              </div>
            </div>

            <button type="submit" class="col-sm-12 btn btn-primary">Создать</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
