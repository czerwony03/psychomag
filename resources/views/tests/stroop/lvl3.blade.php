@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-md-12">
                <div class="card bg-dark text-white" style="height:100%;">
                    <div class="card-header">
                        <span id="stroop-title">Test #1 - Stroop LVL3</span>
                    </div>

                    <div class="card-body d-flex justify-content-around align-items-center">
                        <div class="">
                            <h1 id="stroop-test-msg">
                                <div class="d-flex flex-column" style="font-size:0.5em;">
                                    <span>
                                        Na ekranie pojawią się nazwy kolorów zapisane niezgodnym do nich kolorem czcionki. <br/>
                                        Twoim zadaniem jest wciśnięcie klawisza <strong>Z</strong>-zielony, <strong>C</strong>-czerwony, <strong>B</strong>-biały, <strong>N</strong>-niebieski w zależności od tego jakim kolorem czcionki zapisane zostało słowo.<br/><br/>
                                    </span>
                                    <span class="text-center w-100">
                                        Na przykład gdy na ekranie pojawi się:<br/><span style="color:red;">ZIELONY</span><br/>To Twoim zadaniem będzie wciśnięcie klawisza C<br/><br/><br/>
                                    </span>
                                    <span>
                                        Wykonaj zadanie najszybciej jak potrafisz! Do dzieła!
                                    </span>
                                </div>
                            </h1>
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
                msg.css('color','').append('Trwa generowanie wyniku...');

                let timeSum = 0;
                results.forEach(function(res) {
                    timeSum+=res[1];
                });

                $('#stroop-start').prop('disabled', true);
                $('#stroop-stop').prop('disabled', true);
                const avgtime = Math.round(timeSum/results.length);
                setTimeout(function () {
                    post('{{ route('test.save') }}', {
                        'test_code': '{{ $test_code }}',
                        'test_result': JSON.stringify({
                            'attempts': attempts,
                            'errors': errors,
                            'avg_time': avgtime,
                            'data': results
                        })
                    });
                },3000);
            }
        }
        function showAttempt() {
            console.log('Attempt SHOW');
            let colorStringIndex = Math.floor(Math.random()*colorStrings.length);
            let colorCssIndex = Math.floor(Math.random()*colorCss.length);
            nextAnswer = colorCss[colorCssIndex];
            timeStart = new Date().getTime();
            showText(colorStringIndex,nextAnswer);
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
        function showText(colorStringIndex, styleColor) {
            $('#stroop-test-msg').css('color',styleColor).text(colorStrings[colorStringIndex]);
        }
        function clearMsg() {
            $('#stroop-test-msg').text('');
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
    @include('shared.js')
@endsection
