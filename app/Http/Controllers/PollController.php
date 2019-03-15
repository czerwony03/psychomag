<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollRequest;
use App\Models\Test;
use App\Models\Tester;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PollController extends Controller
{
    static $questions = [
        [
            "Nie jestem smutny ani przygnębiony.",
            "Odczuwam często smutek, przygnębienie.",
            "Przeżywam stale smutek, przygnębienie i nie mogę uwolnić się od tych przeżyć.",
            "Jestem stale tak smutny i nieszczęśliwy, że jest to nie do wytrzymania."
        ],
        [
            "Nie przejmuję się zbytnio przyszłością.",
            "Często martwię się o przyszłość.",
            "Obawiam się, że w przyszłości nic dobrego mnie nie czeka.",
            "Czuję, że przyszłość jest beznadziejna i nic tego nie zmieni."
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ]
    ];
    public function poll_view() {
        return view('poll',["questions" => self::$questions]);
    }

    public function poll_send(PollRequest $request) {
        $pollSum = 0;
        foreach(self::$questions as $question_id => $question) {
            $answer = strval($request->get('question_'.$question_id));
            if(0 <= $answer && $answer <= 3) {
                $pollSum+=$answer;
            }
        }
        $result = [
            "poll_sum" => $pollSum
        ];
        $poll = Test::where('code','=','poll')->first();
        $tester = new Tester();
        $tester->save();
        $tester->tests()->save($poll,[
            'result'=>json_encode($result),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);

        Session::put('tester_uuid',$tester->uuid);

        return redirect(route('test.stroop',["id" => 1]));
    }
}
