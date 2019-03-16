@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @foreach($testsResults as $test)
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
                                {{$key}}: {{$val}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection