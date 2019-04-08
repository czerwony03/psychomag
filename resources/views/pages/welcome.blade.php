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
                            Ewelina<br/><br/>
                            PS. W trakcie testu nie wychodź z tej strony, ponieważ może pojawić sie problem z odczytem klawiatury :).<br/>W razie pojawienia się problemów spróbuj nacisnąć myszką pole testowe!
                        </p>

                        <a href="{{route('poll_view')}}" role="button" class="btn btn-outline-success">START</a>
                        @if(Session::has('tester_uuid'))
                            <a href="{{route('test.next')}}" role="button" class="btn btn-outline-info">KONTYNUUJ</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
