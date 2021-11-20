@extends('layouts.app')

@section('content')
  @if ($questions->where('status', 'expected')->count() !== 0)
    <h2 class="text-primary">Ожидают ответа</h2>
    <table class="table table-condensed">
      <tr>
        <th>||</th>
        <th>№</th>
        <th>Aвтор</th>
        <th>Email</th>
        <th>Вопрос</th>
        <th>Создано</th>
        <th>Обновлено</th>
        <th>Редактировать</th>
      </tr>
      @foreach ($questions as $question)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $question->id }}</td>
          <td>{{ $question->author }}</td>
          <td>{{ $question->email }}</td>
          <td>{{ $question->question }}</td>
          <td>{{ $question->created_at }}</td>
          <td>{{ $question->updated_at }}</td>
          <td><a class="btn btn-primary btn-xs" href="{{ route('admin.question.edit', [$question->id]) }}" role="button">&#9998;</a></td>
        </tr>
      @endforeach
    </table>
  @endif

  @foreach ($topics as $topic)
    @if ($topic->questions->count() !== 0)
      <h2>
        <a href="{{ route('topic.show', [$topic->id]) }}">{{ $topic->topic }}</a>
      </h2>  
      <table class="table table-condensed">
        <tr>
          <th>||</th>
          <th>№</th>
          <th>Aвтор</th>
          <th>Email</th>
          <th>Вопрос</th>
          <th>Ответ</th>
          <th>Статус</th>
          <th>Создано</th>
          <th>Обновлено</th>
          <th>Редактировать</th>
        </tr>
        @foreach ($topic->questions as $question)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $question->id }}</td>
          <td>{{ $question->author }}</td>
          <td>{{ $question->email }}</td>
          <td>{{ $question->question }}</td>
          <td>{{ $question->answer }}</td>
          <td>
            @if ($question->isExpected())
              в ожидании ответа
            @elseif ($question->isPublic())
              опубликовано на главной
            @else
              скрыт
            @endif
          </td>
          <td>{{ $question->created_at }}</td>
          <td>{{ $question->updated_at }}</td>
          <td><a class="btn btn-primary btn-xs" href="{{ route('admin.question.edit', [$question->id]) }}" role="button">&#9998;</a></td>
        </tr>
        @endforeach
      </table>
      <hr>
    @endif
  @endforeach
@endsection
