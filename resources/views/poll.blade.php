@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('poll_send') }}">
            @if ($errors->any())
                <div class="row w-100">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @csrf
                @foreach($questions as $question_id => $question)
                    <div class="row w-100">
                        <div class="card mb-3 w-100">
                            <div class="card-header">Pytanie {{ $question_id+1 }}</div>
                            <div class="card-body" id="question_{{ $question_id }}">
                                @foreach($question as $answer_id => $answer)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="question_{{ $question_id }}" id="question_{{ $question_id }}_radio_{{ $answer_id }}" value="{{ $answer_id }}"{{ null !== old('question_'.$question_id) && old('question_'.$question_id) == $answer_id ? ' checked' : ''}}>
                                        <label class="form-check-label" for="question_{{ $question_id }}_radio_{{ $answer_id }}">{{ $answer }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row w-100">
                    <button type="submit" class="btn btn-primary mb-2">Kontynuuj</button>
                </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">

    </script>
@endsection
