@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::guest())
            <div class="row">
                <div class="col">
                    <div class="card w-100 mb-3">
                        <div class="card-header bg-success">Zakończenie</div>
                        <div class="card-body">
                            Bardzo dziękuje za wzięcie udziału w badaniu!
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="card w-100 mb-3">
                        <div class="card-header bg-info">Dane użytkownika</div>
                        <div class="card-body">
                            <ul>
                                <li>ID: {{$tester->id}}</li>
                                <li>UUID: {{$tester->uuid}}</li>
                                <li>Wykonane testy: {{$tester->tests->count()}}/{{$tests->count()}}</li>
                                <li>Utworzony: {{$tester->created_at}}</li>
                                <li>Zaktualizowany: {{$tester->updated_at}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                @forelse($testsResults as $test)
                    @if($loop->odd)
                        <div class="row">
                    @endif
                    <div class="col">
                        <div class="card w-100 mb-3">
                            <div class="card-header">{{ $test->name }}</div>
                            <div class="card-body">
                                <ul>
                                    @php
                                        $jsonDecoded = json_decode($test->pivot->result);
                                        unset($jsonDecoded->data);
                                    @endphp
                                    @foreach($jsonDecoded as $key=>$val)
                                        <li>
                                            @if(is_array($val))
                                                @if($test->code === \App\Http\Controllers\PollPersonalDataController::CODE)
                                                    {{\App\Http\Controllers\PollPersonalDataController::QUESTIONS[explode('_',$key)[1]-1]["q"]}}:
                                                @else
                                                    {{$key}}:
                                                @endif
                                                <ul>
                                                    @foreach($val as $val2)
                                                        <li>
                                                            @if($test->code === \App\Http\Controllers\PollPersonalDataController::CODE)
                                                                {{\App\Http\Controllers\PollPersonalDataController::QUESTIONS[explode('_',$key)[1]-1]["a"][$val2]}}
                                                            @else
                                                                {{$val2}}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                @if($test->code === \App\Http\Controllers\PollPersonalDataController::CODE)
                                                    {{\App\Http\Controllers\PollPersonalDataController::QUESTIONS[explode('_',$key)[1]-1]["q"]}}:
                                                    {{\App\Http\Controllers\PollPersonalDataController::QUESTIONS[explode('_',$key)[1]-1]["a"][$val]}}
                                                @else
                                                    {{$key}}:
                                                    {{$val}}
                                                @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($loop->even || $loop->last)
                        </div>
                    @endif
                @empty
                <div class="row">
                    <div class="alert alert-danger">
                        Brak wyników
                    </div>
                </div>
                @endforelse
        @endif
    </div>
@endsection
