@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #3 - GO/NO GO ver1</span>
                    </div>

                    <div class="card-body d-flex justify-content-around align-items-center">
                        <div class="">
                            <h1 id="stroop-test-msg">Naciśnij start aby rozpocząć test!</h1>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-around align-items-center">
                        <div>
                            Naciśnij <strong>[B]</strong> gdy widzisz <i class="fa fa-long-arrow-left" style="color:lime;"></i><br/>
                            Naciśnij <strong>[N]</strong> gdy widzisz <i class="fa fa-long-arrow-right" style="color:lime;"></i><br/>
                            Na wykonanie każdej akcji masz 500ms (0.5s)
                        </div>
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
        const BUTTON_NO = 0;
        const BUTTON_B = 1;
        const BUTTON_N = 2;
        const buttons = {
            66:     BUTTON_B,
            98:     BUTTON_B,
            110:    BUTTON_N,
            78:     BUTTON_N
        };
        const answers = [
            BUTTON_B,
            BUTTON_N
        ];
        const arrows = {};
            arrows[BUTTON_B]= 'left';
            arrows[BUTTON_N]= 'right';


        let testStatus = false,
            nextAnswer = null,
            timeStart = null,
            attempts = null,
            results = [],
            errors = null,
            maxTime = 60,
            minTimeout = 1000,
            maxTimeout = 2000,
            actionTimeout,
            currentTimeout,
            testTimeout,
            resultClearTimeout;

        function testStart() {
            console.log('Test START');
            testStatus = true;
            nextAnswer = null;
            timeStart = null;
            attempts = 0;
            results = [];
            errors = 0;
            actionTimeout=null;
            testTimeout=null;
            currentTimeout=null;
            resultClearTimeout=null;
            clearMsg();
            $('#stroop-title').addClass('live');

            testTimeout = setTimeout(testTimeoutFinish, maxTime*1000);
            setNextTimeout();
        }
        function testStop() {
            if(actionTimeout) {
                clearTimeout(actionTimeout);
            }
            if(currentTimeout) {
                clearTimeout(currentTimeout);
            }
            if(resultClearTimeout) {
                clearTimeout(resultClearTimeout);
            }
            currentTimeout = null;
            console.log('Test STOP');
            testStatus = false;
            $('#stroop-title').removeClass('live');
            toggleButtons();
            var msg = $("#stroop-test-msg");
            if(testTimeout) {
                clearTimeout(testTimeout);
                testTimeout = null;
                msg.text('Test przerwany. Naciśnij start, aby spróbować ponownie!').css('color','');
            } else {
                clearMsg();
                var list = msg.append('Wyniki:<br/><ul></ul>').find('ul');
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
        function showAttempt() {
            console.log('Attempt SHOW');
            let buttonIndex = Math.floor(Math.random()*answers.length);
            nextAnswer = answers[buttonIndex];
            timeStart = new Date().getTime();
            showText('<i style="color:lime; font-size:8em;" class="fa fa-long-arrow-' + arrows[answers[buttonIndex]] + '"></i>');
            actionTimeout = setTimeout(function() {
                attemptResult(false,500);
            }, 500);
        }
        function attemptResult(status,calculatedTime=null) {
            console.log('Attempt ANSWER',status);
            clearMsg();
            attempts++;
            nextAnswer=null;
            if(!calculatedTime) {
                clearTimeout(actionTimeout);
                calculatedTime = new Date().getTime()-timeStart;
            }
            actionTimeout=null;
            results.push([
                status,
                calculatedTime
            ]);
            if(!status) {
                errors++;
                if(calculatedTime===500) {
                    showText('<span style="color:yellow;">ZBYT WOLNO</span>');
                } else {
                    showText('<span style="color:red;">ŹLE</span>');
                }
            } else {
                showText('<span style="color:lime;">OK</span>');
            }
            resultClearTimeout = setTimeout(function() { clearMsg(); }, 500);
            setNextTimeout();
        }
        function setNextTimeout() {
            currentTimeout = setTimeout(showAttempt, randomInt(minTimeout,maxTimeout));
        }
        function showText(text) {
            $('#stroop-test-msg').html(text);
        }
        function clearMsg() {
            $('#stroop-test-msg').html('');
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
                if(actionTimeout) {
                    if(nextAnswer && nextAnswer === buttons[key]) {
                        attemptResult(true);
                    } else {
                        attemptResult(false);
                    }
                }
            }
        });

    </script>
@endsection
