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
                                <li>Stroop:
                                    <ul>
                                        <li><a href="{{ url('stroop1') }}">LVL 1</a></li>
                                        <li><a href="{{ url('stroop2') }}">LVL 2</a></li>
                                        <li><a href="{{ url('stroop3') }}">LVL 3</a></li>
                                        <li><a href="{{ url('stroop4') }}">LVL 4</a></li>
                                    </ul>
                                </li>
                                <li>
                                    TMT:
                                    <ul>
                                        <li><a href="{{ url('tmtA') }}">Test A</a></li>
                                        <li><a href="{{ url('tmtB') }}">Test B</a></li>
                                    </ul>
                                </li>
                                <li>
                                    Go/No go
                                    <ul>
                                        <li><a href="{{ url('go_nogo_one') }}">#1</a></li>
                                        <li><a href="{{ url('go_nogo_two') }}">#2</a></li>
                                    </ul>
                                </li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
