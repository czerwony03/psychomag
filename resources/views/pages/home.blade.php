@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Panel</div>

                    <div class="card-body">
                        Obiekty testowe: <a href="{{ route('auth.tests.objects') }}">Link</a><br/>
                        Obiekty testowe - ganja: <a href="{{ route('auth.tests.objects_ganja') }}">Link</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
