@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="{{ route('admin.question.update', [$question->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
              <label for="author" class="col-sm-3 control-label">Имя</label>
              <div class="col-sm-9">
                <input type="text" name="author" required class="form-control" id="name" value="{{ $question->author }}">
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-sm-3 control-label">Email</label>
              <div class="col-sm-9">
                <input type="email" name="email" required class="form-control" id="email" value="{{ $question->email }}">
              </div>
            </div>
            <div class="form-group">
              <label for="status" class="col-sm-3 control-label">Статус</label>
              <div class="col-sm-9">
                <select name="status" class="form-control">
                  <option value="public">Опубликован</option>
                  <option value="hidden">Скрыт</option>
                  <option value="expected">Нет ответа</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="topic_id" class="col-sm-3 control-label">Тема</label>
              <div class="col-sm-9">
                <select name="topic_id" class="form-control">
                  <option value="{{ $question->topic->id }}">{{ $question->topic->topic }}</option>
                  @foreach ($topics as $topic)
                    @if ($topic->id !== $question->topic->id)
                    <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="question" class="col-sm-3 control-label">Вопрос</label>
              <div class="col-sm-9">
                <textarea name="question" required class="form-control" rows="3">{{ $question->question }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="answer" class="col-sm-3 control-label">Ответ</label>
              <div class="col-sm-9">
                <textarea name="answer" required class="form-control" rows="6">{{ $question->answer }}</textarea>
              </div>
            </div>
            <hr>
            <button type="submit" class="col-sm-4 col-sm-offset-1 btn btn-primary">Применить</button>
          </form>
          <form action="{{ route('admin.question.destroy', [$question->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="col-sm-4 col-sm-offset-2 btn btn-danger">Удалить</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
