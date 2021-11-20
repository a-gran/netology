@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <form class="form-horizontal" role="form" action="{{ route('user.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Login</label>
            <div class="col-sm-9">
              <input type="text" name="name" required class="form-control" id="name" value="{{ old('name') }}">
            </div>
          </div>

          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
              <input type="email" name="email" required class="form-control" id="email" value="{{ old('email') }}">
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Pass</label>
            <div class="col-sm-9">
              <input type="password" name="password" required class="form-control" id="password">
            </div>
          </div>

          <button type="submit" class="col-sm-12 btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
