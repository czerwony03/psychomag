@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #1 - Stroop LVL4</span>
                    </div>

                    <div class="card-body d-flex justify-content-around align-items-center">
                        <div class="d-flex flex-column" style="font-size:1em;" id="testinstruction">
                            <span>
                                Na ekranie pojawią się nazwy kolorów napisane różnymi kolorami czcionki. Będą się one pojawiały w ramce lub poza nią. <br/>
                                Twoim zadaniem jest wciśnięcie klawisza <strong>Z</strong>-zielony, <strong>C</strong>-czerwony, <strong>B</strong>-biały, <strong>N</strong>-niebieski w zależności od tego jakim kolorem czcionki zapisane zostało słowo gdy pojawi się ono poza ramką, a gdy słowo pojawi się w ramce Twoim zadaniem będzie zaznaczyć nazwę koloru, a nie kolor czcionki.<br/><br/>
                            </span>
                            <div class="d-flex flex-row justify-content-around">
                                <div class="d-flex flex-column">
                                    <span class="text-center w-100">
                                        Na przykład gdy na ekranie pojawi się:
                                    </span>
                                    <span class="text-center w-100" style="color:green;">NIEBIESKI</span>
                                    <span class="d-flex justify-content-center">
                                        <div style="height: 50px; width: 100px; border: 1px solid black; color:green;"></div>
                                    </span>
                                    <span class="text-center w-100">
                                        To Twoim zadaniem  będzie wciśnięcie klawisza Z<br/><br/><br/>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-center w-100">
                                        Na przykład gdy na ekranie pojawi się:
                                    </span>
                                    <span class="text-center w-100" style="color:green;">&nbsp;</span>
                                    <span class="d-flex justify-content-center">
                                        <div class="text-center" style="height: 50px; width: 100px; border: 1px solid black; color:green;">NIEBIESKI</div>
                                    </span>
                                    <span class="text-center w-100">
                                        To Twoim zadaniem  będzie wciśnięcie klawisza N<br/><br/><br/>
                                    </span>
                                </div>
                            </div>
                            <span class="text-center">
                                Wykonaj zadanie najszybciej jak potrafisz! Do dzieła!
                            </span>
                        </div>
                        <div class="d-flex flex-column justify-content-around align-items-center" style="width:50%;height:50%;display:none;" id="testfield">
                            <h1 id="stroop-test-msg" class="h-100 w-100" style="text-align: center;"></h1>
                            <h1 id="stroop-test-boxmsg" class="h-100 w-100" style="text-align: center; display:none;">-</h1>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-around align-items-center">
                        <span style="color:green"><strong>[Z]</strong>ielony</span>
                        <span style="color:red"><strong>[C]</strong>zerwony</span>
                        <span style="color:white"><strong>[B]</strong>iały</span>
                        <span style="color:dodgerblue"><strong>[N]</strong>iebieski</span>
                        <span>
                            <button class="btn btn-success" id="stroop-start">START</button>
                            <button class="btn btn-danger" id="stroop-stop" disabled>STOP</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        let testStatus = false,
            nextAnswer = null,
            timeStart = null,
            attempts = null,
            results = [],
            errors = null,
            maxTime = 60,
            minTimeout = 1000,
            maxTimeout = 2000,
            currentTimeout,
            testTimeout;

        const colorStrings = [
            "ZIELONY",
            "CZERWONY",
            "BIAŁY",
            "NIEBIESKI"
        ];
        const colorCss = [
            "green",
            "red",
            "white",
            "blue"
        ];
        const colorButtons = {
            122:    0, // Z
            90:     0, // z
            99:     1, // c
            67:     1, // C
            66:     2, // B
            98:     2, // b
            110:    3, // n
            78:     3  // N
        };

        function testStart() {
            $('#testinstruction').attr('style','display:none !important');
            $('#testfield').css({'display':'block'});
            console.log('Test START');
            testStatus = true;
            nextAnswer = null;
            timeStart = null;
            attempts = 0;
            results = [];
            errors = 0;
            testTimeout=null;
            currentTimeout=null;
            clearMsg();
            $('#stroop-title').addClass('live');
            $('#stroop-test-boxmsg').css({'display':'block'});

            testTimeout = setTimeout(testTimeoutFinish, maxTime*1000);
            setNextTimeout();
        }
        function testTimeoutFinish() {
            if(currentTimeout) {
                clearTimeout(currentTimeout);
            }
            currentTimeout = null;
            if(testTimeout) {
                clearTimeout(testTimeout);
            }
            testTimeout = null;
            testStop();
        }
        function testStop() {
            if(currentTimeout) {
                clearTimeout(currentTimeout);
            }
            currentTimeout = null;
            console.log('Test STOP');
            testStatus = false;
            $('#stroop-title').removeClass('live');
            $('#stroop-test-boxmsg').css({'display':'none'});
            toggleButtons();
            var msg = $("#stroop-test-msg");
            if(testTimeout) {
                if(testTimeout) {
                    clearTimeout(testTimeout);
                }
                testTimeout = null;
                msg.text('Test przerwany. Naciśnij start, aby spróbować ponownie!').css('color','');
            } else {
                clearMsg();
                var list = msg.css('color','').append('Wyniki:<br/><ul></ul>').find('ul');
                results.forEach(function (result) {
                    list.append('<li>' + trueFalse(result[0]) + ' ' + result[1] + '</li>');
                });
                msg.append('<br/>Błędnych odpowiedzi: ' + errors + '/' + attempts);

                let timeSum = 0;
                results.forEach(function(res) {
                    timeSum+=res[1];
                });
                msg.append('<br/>Średni czas reakcji: ' + Math.round(timeSum/results.length) + 'ms');
            }
        }
        function showAttempt() {
            console.log('Attempt SHOW');
            let colorStringIndex = Math.floor(Math.random()*colorStrings.length);
            let colorCssIndex = Math.floor(Math.random()*colorCss.length);
            let inBoxOrNot = Math.random() >= 0.5;
            timeStart = new Date().getTime();
            console.log(inBoxOrNot);
            if(inBoxOrNot){
                $('#stroop-test-boxmsg').css('color',colorCss[colorCssIndex]).text(colorStrings[colorStringIndex]);
                nextAnswer = colorCss[colorStringIndex];
            } else {
                $('#stroop-test-msg').css('color',colorCss[colorCssIndex]).text(colorStrings[colorStringIndex]);
                nextAnswer = colorCss[colorCssIndex];
            }
        }
        function attemptResult(status) {
            console.log('Attempt ANSWER');
            clearMsg();
            attempts++;
            nextAnswer=null;
            let calculatedTime = new Date().getTime()-timeStart;
            results.push([
                status,
                calculatedTime
            ]);
            if(!status) {
                errors++;
            }

            setNextTimeout();
        }
        function setNextTimeout() {
            currentTimeout = setTimeout(showAttempt, randomInt(minTimeout,maxTimeout));
        }
        function clearMsg() {
            $('#stroop-test-msg').text('');
            $('#stroop-test-boxmsg').text('');
        }
        function randomInt(min,max) {
            return Math.floor(Math.random()*(max-min+1)+min);
        }
        function toggleButtons() {
            $('#stroop-start').prop('disabled', function(i, v) { return !v; });
            $('#stroop-stop').prop('disabled', function(i, v) { return !v; });
        }
        function trueFalse(status) {
            return (status ? 'Ok' : 'Błąd')
        }
        $('#stroop-start').on('click',function() {
            toggleButtons();
            testStart();
        });
        $('#stroop-stop').on('click',function() {
            testStop();
        });

        $(document).on('keypress',function(e) {
            if(testStatus) {
                let key = parseInt(e.which,10);
                Object.keys(colorButtons).map(function(indexMap) {
                    let index = parseInt(indexMap,10);
                    if(index === key) {
                        if(nextAnswer && nextAnswer === colorCss[colorButtons[index]]) {
                            attemptResult(true);
                        } else if(nextAnswer) {
                            attemptResult(false);
                        }
                    }
                });
            }
        });
    </script>
@endsection
