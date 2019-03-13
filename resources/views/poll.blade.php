@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($questions as $question_id => $question)
            <div class="row w-100">
                <div class="card mb-3 w-100">
                    <div class="card-header">Pytanie {{ $question_id+1 }}</div>
                    <div class="card-body" id="question_{{ $question_id }}">
                        @foreach($question as $answer_id => $answer)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_{{ $question_id }}" id="question_{{ $question_id }}_radio_{{ $answer_id }}" value="{{ $answer_id }}">
                                <label class="form-check-label" for="question_{{ $question_id }}_radio_{{ $answer_id }}">{{ $answer }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">

    </script>
@endsection
