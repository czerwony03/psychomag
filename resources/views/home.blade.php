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
                        <a href="{{ url('stroop') }}">Test Stroop'a</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
