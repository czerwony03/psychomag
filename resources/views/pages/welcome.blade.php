@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cześć!</div>

                    <div class="card-body">
                        <p>Jestem studentką IV roku psychologii Uniwersytetu Marii Curie-Skłodowskiej i prowadzę badania do pracy magisterskiej.<br/>
                            Poruszam w niej tematykę funkcjonowania poznawczego młodych dorosłych.<br/>
                            Bardzo Cię proszę o pomoc! Poświęć mi około 20 minut.<br/>
                            Na początku uzupełnisz kwestionariusz składający się z 21 pytań, następnie zagrasz w kilka „gier”, na zakończenie ponownie odpowiesz na 8 pytań.<br/>
                            Jestem pewna, że z Twoją pomocą nazbieram odpowiednią liczbę osób badanych!<br/>
                            <br/><strong>Badanie jest CAŁKOWICIE ANONIMOWE i dobrowolne, możesz z niego zrezygnować, w każdym momencie jego trwania.</strong><br/>
                            <br/>Z góry dziękuję,<br/>
                            Ewelina
                        </p>

                        <a href="{{route('poll_view')}}"><button class="btn btn-success"><h1>START</h1></button></a>
                        @if(Session::has('tester_uuid'))
                            <a href="{{route('test.next')}}"><button class="btn btn-info"><h1>KONTYNUUJ</h1></button></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span class="text-muted float-right"><strong>Created by <a href="https://redtm.pl/" style="color:red;">RedTM.pl</a></strong></span>
        </div>
    </footer>
@endsection
