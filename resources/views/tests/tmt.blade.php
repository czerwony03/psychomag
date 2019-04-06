@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12 h-100">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #2 - TMT {{$ver}}</span>
                    </div>

                    <div class="card-body d-flex justify-content-around align-items-center" id="tmttest" data-ver="{{$ver}}"></div>

                    <div class="card-footer d-flex justify-content-around align-items-center">
                        Naciśnij kolejne numery.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
@endsection
