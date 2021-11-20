@extends('layouts.app')

@section('content')
  <h2>Темы</h2>
  <table class="table table-condensed">
    <tr>
      <th>//</th>
      <th>Название</th>
      <th>Сколько вопросов</th>
      <th>Опубликованы</th>
      <th>Нет ответа</th>
      <th>Подробнее</th>
    </tr>
    @foreach ($topics as $topic)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $topic->topic }}</td>
      <td>{{ $topic->questions->count() }}</td>
      <td>{{ $topic->questions->where('status', 'public')->count() }}</td>
      <td>{{ $topic->questions->where('status', 'expected')->count() }}</td>
      <td><a class="btn btn-primary btn-xs" href="{{ route('topic.show', [$topic->id]) }}" role="button">&#9998;</a></td>
    </tr>
    @endforeach
  </table>
  <hr>
  <a class="col-md-12 btn btn-primary" href="{{ route('topic.create') }}">Добавить еще тему</a>
@endsection
