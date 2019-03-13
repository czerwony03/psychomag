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
                            Ankieta: <a href="{{ route('poll_view') }}">Link</a><br/>
                            Testy:
                            <ul>
                                <li>Stroop:
                                    <ul>
                                        <li><a href="{{ route('stroop1') }}">LVL 1</a></li>
                                        <li><a href="{{ route('stroop2') }}">LVL 2</a></li>
                                        <li><a href="{{ route('stroop3') }}">LVL 3</a></li>
                                        <li><a href="{{ route('stroop4') }}">LVL 4</a></li>
                                    </ul>
                                </li>
                                <li>
                                    TMT:
                                    <ul>
                                        <li><a href="{{ route('tmtA') }}">Test A</a></li>
                                        <li><a href="{{ route('tmtB') }}">Test B</a></li>
                                    </ul>
                                </li>
                                <li>
                                    Go/No go
                                    <ul>
                                        <li><a href="{{ route('go_nogo_one') }}">#1</a></li>
                                        <li><a href="{{ route('go_nogo_two') }}">#2</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('wcst') }}">WCST</a>
                                </li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
