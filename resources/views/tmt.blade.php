@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #2 - TMT A</span>
                    </div>

                    <div class="card-body d-flex justify-content-around align-items-center" id="tmttest"></div>

                    <div class="card-footer d-flex justify-content-around align-items-center">
                        <!--<span style="color:green"><strong>[Z]</strong>ielony</span>
                        <span style="color:red"><strong>[C]</strong>zerwony</span>
                        <span style="color:white"><strong>[B]</strong>iały</span>
                        <span style="color:dodgerblue"><strong>[N]</strong>iebieski</span>
                        <span>
                            <button class="btn btn-success" id="stroop-start">START</button>
                            <button class="btn btn-danger" id="stroop-stop" disabled>STOP</button>
                        </span>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
@endsection
