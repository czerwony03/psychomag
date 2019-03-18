<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollPumRequest;
use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class PollPumController extends Controller
{
    const CODE = 'poll_pum';
    static $questions = [
        "Zdarzyło mi się nie pójść lub spóźnić się do pracy/szkoły z powodu używania marihuany.",
        "Z powodu używania marihuany miałem/am poważny konflikt z rodziną.",
        "Z powodu używania marihuany miałem/am poważny konflikt z przyjaciółmi.",
        "Zdarzyło mi się samodzielnie kupić marihuanę.",
        "Mam coraz więcej kłopotów z przyswajaniem nowych informacji.",
        "Zdarzało mi się palić marihuanę w samotności.",
        "Często odczuwam potrzebę użycia marihuany.",
        "Zdarzyło mi się wydać na marihuanę tak dużo pieniędzy, że musiałem/am zrezygnować z innych rzeczy, na których mi zależało."
    ];
    static $answers = [
        "Zdecydowanie nie zgadzam się.",
        "Raczej nie zgadzam się.",
        "Ani się nie zgadzam, ani zgadzam.",
        "Raczej zgadzam się.",
        "Zdecydowanie zgadzam się."
    ];

    public function poll_view() {
        return view('polls.pum',["questions" => self::$questions,"answers" => self::$answers]);
    }

    public function poll_send(PollPumRequest $request) {
        $answers = [];
        foreach(self::$questions as $question_id => $question) {
            $answer = strval($request->get('question_'.$question_id));
            if(1 <= $answer && $answer <= 5) {
                $answers["question_".($question_id+1)]=$answer;
            }
        }
        $poll = Test::where('code','=',self::CODE)->first();
        $tester = $request->get('testerModel');
        $tester->save();
        $tester->tests()->save($poll,[
            'result'=>json_encode($answers),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);

        return redirect(route('test.next'));
    }
}
