@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Panel</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Logowanie poprawne!<br/>
                            Testy:
                            <ul>
                                <li><a href="{{ url('stroop') }}">Test Stroop'a</a></li>
                                <li><a href="{{ url('tmt') }}">Test TMT A</a></li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
