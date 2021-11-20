@extends('layouts.app')

@section('content')
  <h2>Список админов</h2>
  <table class="table table-condensed">
    <tr>
      <th>\\</th>
      <th>Login</th>
      <th>Email</th>
      <th>Изменить пароль</th>
    </tr>
    @foreach ($users as $user)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td><a class="btn btn-primary btn-xs" href="{{ route('user.edit', [$user->id]) }}" role="button">&#9998;</a></td>
    </tr>
    @endforeach
  </table>
  <hr>
  <a class="col-md-12 btn btn-primary" href="{{ route('user.create') }}">Добавить админа</a>
@endsection
