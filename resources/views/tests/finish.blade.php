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
                @forelse($testsResults as $test)
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
                                            {{$key}}:
                                            @if(is_array($val))
                                                <ul>
                                                    @foreach($val as $val2)
                                                        <li>{{$val2}}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                {{$val}}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($loop->iteration % 2)
                        <div class="w-100"></div>
                    @endif
                @empty
                    <div class="alert alert-danger">
                        Brak wyników
                    </div>
                @endforelse
            </div>
        @endif
    </div>
@endsection
