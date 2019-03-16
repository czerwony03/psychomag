@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #4 - Wisconsin Card Sorting</span>
                    </div>

                    <div class="card-body" id="wcst">
                        <div id="WCSTinstructions">
                            <p>Ten test jest nietypowy, ponieważ nie ma żadnej instrukcji.</p>

                            <p>Dostajesz dwie talie kart, z których każda zawiera 64 karty. Twoim zadaniem jest posortowanie tych kart na 4 różne stosy. Prawidłowa odpowiedź zależy od reguły, ale nie wiesz, co to za reguła. Po każdej próbie powiemy Ci, czy masz rację. Po umieszczeniu karty na właściwym stosie na ekranie pojawi się słowo "DOBRZE". A kiedy położysz kartę na niewłaściwym stosie, pojawi się słowo "ŹLE". Celem jest zdobycie jak największej ilości kart na stos "prawidłowy".</p>

                            <p>Użyj myszki aby dokonać wyboru.</p>
                            <p style="font-weight: bold;"><button class="btn btn-success" id="wcst-start">START</button></p>
                        </div>

                        <div id="WCSTkeyCards" style="display: none;">
                            <img src="{{ asset('img/111.jpg') }}" height="150" width="150" style="margin:50px 10px 50px 50px; cursor:pointer; cursor:hand;"
                                 onClick="WCSTcardPressed(1);">			<!-- card: 1 circle red -->
                            <img src="{{ asset('img/222.jpg') }}" height="150" width="150" style="margin:50px 10px; cursor:pointer;cursor:hand;"
                                 onClick="WCSTcardPressed(2);">					<!-- card: 2 diamonds green -->
                            <img src="{{ asset('img/333.jpg') }}" height="150" width="150" style="margin:50px 10px; cursor:pointer;cursor:hand;"
                                 onClick="WCSTcardPressed(3);">					<!-- card: 3 stars blue -->
                            <img src="{{ asset('img/444.jpg') }}" height="150" width="150" style="margin:50px 10px; cursor:pointer;cursor:hand;"
                                 onClick="WCSTcardPressed(4);">					<!-- card: 4 triangles yelow -->
                        </div>

                        <!-- The showing the response card here (the cards that needs to be sorted to one of the four piles) -->
                        <img src="blank.png" id="WCSTresponseCard" alt="just nothing" height="150" width="150" style="margin:0px 0px 0px 400px; display: none;"/>

                        <!-- Feedback to the participant after choosing a pile the response card belongs to - was he right or wrong. -->
                        <p id="WCSTright" style="color:lime; display: none; margin:0px 10px 10px 400px; font-size:3em; font-weight:bold;">DOBRZE</p>
                        <p id="WCSTwrong" style="color:red; display: none; margin:0px 10px 10px 400px; font-size:3em; font-weight:bold;">ŹLE</p>

                        <!-- Once the game is finished - End instructions are shown -->
                        <div id="WCSTendInstructions" style="display: none;">
                            <p>Wyniki:</p>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-around align-items-center">
                        <p id="WCSTgameInstructions" style="display: none;">Naciśnij jedną z 4 kart która najlepiej pasuje do tej karty: </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>

        var state = 'WCSTinstructions';

        $(window).keypress(function(e) {
            if (e.keyCode == 32) { // space
                if (state == 'WCSTinstructions') {
                    WCSTstateTransitionToGame();
                }
            }
        });

        $('#wcst-start').click(function() {
            if (state == 'WCSTinstructions') {
                WCSTstateTransitionToGame();
            }
        });

        function WCSTcardPressed(cardNumber) {
            if ((state == 'WCSTgame') && (isKeyPressed == 0)) {
                WCSTgameKeyPressed(cardNumber);
            }
        }

        function WCSTstateTransitionToGame() {
            $('#WCSTinstructions').hide();
            $('#WCSTgameInstructions').show();
            $('#WCSTkeyCards').show();
            state = 'WCSTgame';

            card = cards[0];
            document.getElementById('WCSTresponseCard').src = window.location.origin + "/img/" + card.toString() + ".jpg";
            $('#WCSTresponseCard').show();
            startTime = Date.now();
        }

        function WCSTstateTransitionToEnd() {		//At this state only the end instructions should appear (Thank you for participating...)
            $('#WCSTkeyCards').hide();
            $('#WCSTgameInstructions').hide();
            $('#WCSTwrong').hide();
            $('#WCSTright').hide();
            setTimeout(function() {
                let instruction = $('#WCSTendInstructions');
                instruction.show();
                let list = instruction.append('<br/><ul></ul>').find('ul');
                list.append('<li>Łącznie: ' + total + '</li>');
                list.append('<li>Błędów: ' + totalWrong + '</li>');
                list.append('<li>Błędy perseweracyjne: ' + totalRepeatedWrong + '</li>');
            }, 1000);

            post('{{ route('test.save') }}', {
                'test_code': '{{ $test_code }}',
                'test_result': JSON.stringify({
                    'attempts': total,
                    'errors': totalWrong,
                    'repeated_errors': totalRepeatedWrong,
                    'completed_decks': seriesNumber
                })
            });
        }

        // The cards needed to be sorted into the piles are in a pseudo random order that repeats itself twice (as if we had 2 identical decks of cards)
        // In each deck there is one card for each possible combination of number (1/2/3/4), shape (circle/diamond/star/triangle), and color (red/green/blue/yellow)
        // so we have 4X4X4=64 cards in a deck.
        // The cards names are XXX=>number,shape,color - for example card name 234 is a card with 2 stars that are yellow.
        var cards = [234, 423, 244, 314, 134, 133, 242, 213, 414, 124, 324, 343, 334, 434, 223, 422, 131, 432, 241, 412, 323, 344, 413, 243, 331, 411, 341, 132, 112, 214, 111, 312, 311, 342, 141, 322, 441, 222, 123, 211, 421, 424, 431, 233, 122, 232, 333, 433, 442, 113, 212, 114, 224, 444, 221, 321, 231, 121, 143, 144, 332, 142, 443, 313, 234, 423, 244, 314, 134, 133, 242, 213, 414, 124, 324, 343, 334, 434, 223, 422, 131, 432, 241, 412, 323, 344, 413, 243, 331, 411, 341, 132, 112, 214, 111, 312, 311, 342, 141, 322, 441, 222, 123, 211, 421, 424, 431, 233, 122, 232, 333, 433, 442, 113, 212, 114, 224, 444, 221, 321, 231, 121, 143, 144, 332, 142, 443, 313];

        var classificationPrinceple = 0;	//Classification principle 0=>by_count 1=>by_shape 2=>by+color
        var countRight = 0;					//Counting how many are consecutive correct (in order to change the classification principle after 10 correct).
        var seriesNumber = 0;				//WCST tests how many series (a series = 10 consecutive correct) the participants completed.

        var total = 0;
        var totalWrong = 0;					//WCST tests the total amount of wrong answers the participant had.
        var totalRepeatedWrong = 0; 		//WCST tests the total amount of wrong answers that the type of mistake was exactly like the mistake from the privious trial.
        var previousTrialWrongType = -1;	//For this we always need to know if last trial was a wrong (error) and the type of error. -1 means right.
        var currentTrialWrongType = -2;		//And we need the type of error in the current trial to compare to last trial. -2 is right (correct response).
        //The error types can be 0/1/2  -  0=>sorted_by_count 1=>by_shape 2=>by_color

        var isKeyPressed = 0;				//Tracks the keypress for each card so players won't press out of time

        var startTime;

        var Seq = 1;
        function WCSTlogKeyPressed(code) {

            WCSTaddVariable("key-" + Seq, code);
            WCSTaddVariable("reaction-time(ms)", (Date.now()-startTime));
            WCSTaddVariable("series-completed", seriesNumber);
            WCSTaddVariable("wrong-sum", totalWrong);
            WCSTaddVariable("repeated-wrong", totalRepeatedWrong);
            Seq++;
        }

        function WCSTaddVariable(name, value) {
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", name );
            input.setAttribute("value", value);
            //append to form element that you want .
            document.body.appendChild(input);
        }

        function WCSTdesplayRight() {
            $('#WCSTright').show().delay(1000).hide(1);
            countRight++;
            total++;
            previousTrialWrongType = -1;
            currentTrialWrongType = -2;
        }

        function WCSTdesplayWrong() {
            $('#WCSTwrong').show().delay(1000).hide(1);
            countRight=0;
            totalWrong++;
            total++;
        }

        function WCSTgameKeyPressed(code) {

            isKeyPressed = 1;

            switch(classificationPrinceple) {
                case 0:
                    if (code == Math.floor(card/100)) {
                        WCSTdesplayRight();
                    } else {
                        WCSTdesplayWrong();
                        if (code == (Math.floor(card/10)%10)) {
                            currentTrialWrongType = 1;
                        } else if (code == Math.floor(card%10)) {
                            currentTrialWrongType = 2;
                        } else {
                            currentTrialWrongType = 3;
                        }
                    }
                    break;
                case 1:
                    if (code == (Math.floor(card/10)%10)) {
                        WCSTdesplayRight();
                    } else {
                        WCSTdesplayWrong();
                        if (code == Math.floor(card/100)) {
                            currentTrialWrongType = 0;
                        } else if (code == Math.floor(card%10)) {
                            currentTrialWrongType = 2;
                        } else {
                            currentTrialWrongType = 3;
                        }
                    }
                    break;
                default:
                    if (code == Math.floor(card%10)) {
                        WCSTdesplayRight();
                    } else {
                        WCSTdesplayWrong();
                        if (code == Math.floor(card/100)) {
                            currentTrialWrongType = 0;
                        } else if (code == (Math.floor(card/10)%10)) {
                            currentTrialWrongType = 1;
                        } else {
                            currentTrialWrongType = 3;
                        }
                    }
            }

            if (currentTrialWrongType != -2) {
                if (currentTrialWrongType == previousTrialWrongType) {
                    totalRepeatedWrong++;
                }
                previousTrialWrongType = currentTrialWrongType;
            }

            $('#WCSTresponseCard').hide();

            cards.shift();

            if ((cards.length!=0) && (seriesNumber<6) && (total<128)) {

                card = cards[0];
                document.getElementById('WCSTresponseCard').src = window.location.origin + "/img/" + card.toString() + ".jpg";

                setTimeout(function() {
                    $("#WCSTresponseCard").show();
                    isKeyPressed = 0;
                    startTime = Date.now();
                }, 1500);

            } else {
                state = 'WCSTEnd';
                WCSTstateTransitionToEnd();
            }

            if (countRight == 10) {
                classificationPrinceple = (classificationPrinceple+1) % 3;
                countRight = 0;
                seriesNumber++;
            }

            WCSTlogKeyPressed(code);

        }

    </script>
    @include('shared.js')
@endsection
