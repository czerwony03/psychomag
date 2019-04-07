@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row w-100">
            <div class="card mb-3 w-100">
                <div class="card-body">
                    W każdym pytaniu wybierz jedną odpowiedź, która najlepiej określa Twoje uczucia <strong>podczas ostatnich 7 dni</strong> (a nie tylko w dniu dzisiejszym).<br/>W przypadku wątpliwości, zadaj sobie pytanie: <i>Która z odpowiedzi jest najbliższa temu co czuję i myślę?</i>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('poll_send') }}">
            @if ($errors->any())
                <div class="row w-100">
                    <div class="alert alert-danger">
                        <strong>Uwaga!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                @if($loop->iteration<=3)
                                    <li>{{ $error }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @csrf
                @foreach($questions as $question_id => $question)
                    @php ($question_text = 'question_'.$question_id)
                    <div class="row w-100">
                        <div class="card mb-3 w-100">
                            <div class="card-header">Pytanie {{ $question_id+1 }}</div>
                            <div class="card-body" id="{{$question_text}}">
                                @foreach($question as $answer_id => $answer)
                                    @php ($question_answer_text = 'question_'.$question_id.'_radio_'.$answer_id)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{$question_text}}" id="{{$question_answer_text}}" value="{{ $answer_id }}"{{ null !== old($question_text) && old($question_text) == $answer_id ? ' checked' : ''}}>
                                        <label class="form-check-label" for="{{$question_answer_text}}">{{ $answer }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @if($errors->first('question_'.$question_id))
                                <div class="card-footer" style="color:red;">
                                    <small>{{ $errors->first($question_text) }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="row w-100">
                    <div class="card mb-3 w-100">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary mb-2">Kontynuuj</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">

    </script>
@endsection
