@extends('layouts.app')

@section('content')
  <div class="col-md-3">
    <ul class="nav nav-tabs nav-stacked">
      @foreach ($topics as $topic)
        @if ($topic->questions->where('status', 'public')->count() !== 0)
          <li role="presentation"><a href="#{{ $topic->id }}">{{ $topic->topic }}</a></li>
        @endif
      @endforeach
      <li role="presentation"><a class="create" href="{{ route('question.create') }}">Задайте свой вопрос</a></li>
    </ul>  
  </div>

  <div class="col-md-9">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        @foreach ($topics as $topic)
          @if ($topic->questions->where('status', 'public')->count() !== 0)
          <div class="panel-heading" id="{{ $topic->id }}">
            <h2 class="text-primary">{{ $topic->topic }}</h2>
          </div>
          <hr>
            @foreach ($topic->questions as $question)
              @isset($question['answer'])
                @if ($question->isPublic())
                  <div class="panel-heading" role="tab" id="heading{{ $loop->parent->index }}{{ $loop->index }}">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $loop->parent->index }}{{ $loop->index }}" aria-expanded="true" aria-controls="collapse{{ $loop->parent->index }}{{ $loop->index }}">
                        <p>{{ $question['question'] }}</p>
                      </a>
                    </h4>
                  </div>
                  <div id="collapse{{ $loop->parent->index }}{{ $loop->index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $loop->parent->index }}{{ $loop->index }}">
                    <div class="panel-body">
                      <p>Автор: {{ $question['author'] }}</p>
                      <p>{{ $question['created_at'] }}</p>
                      <div class="panel-body">
                      <p>Ответ: {{ $question['answer'] }}</p>
                      </div>
                      {{ $question['updated_at'] }}
                    </div>
                    <hr>
                  </div>
                @endif
              @endisset
            @endforeach
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
