@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">UUID</th>
                    <th scope="col">Tests</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">Wyniki</th>
                </tr>
                </thead>
                <tbody>
                @foreach($testers as $tester)
                    <tr{{ $tester->tests->count()>=$tests->count() ? ' class="table-success"' : '' }}>
                        <th scope="row">{{$tester->id}}</th>
                        <td>{{$tester->uuid}}</td>
                        <td>{{$tester->tests->count()}}/{{$tests->count()}}</td>
                        <td>{{$tester->created_at}}</td>
                        <td>{{$tester->updated_at}}</td>
                        <td>
                            <a role="button" class="btn btn-info btn-sm" href="{{route('auth.tests.object.result',["id"=>$tester->id])}}">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
