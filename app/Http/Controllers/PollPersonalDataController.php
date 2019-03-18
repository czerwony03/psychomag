<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollPersonalDataRequest;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class PollPersonalDataController extends Controller
{
    const CODE = 'poll_personal_data';
    const QUESTIONS = [
        [
            "q" => "Płeć",
            "a" => [
                "Mężczyzna",
                "Kobieta"
            ]
        ], [
            "q" => "Wiek",
            "a" => [
                "<13",
                "13-18",
                "19-24",
                "25-30",
                "31-36",
                "37-42",
                "43-48",
                ">49"
            ]
        ]
    ];
    public function poll_view() {
        return view('polls.personal_data',["questions" => self::QUESTIONS]);
    }

    public function poll_send(PollPersonalDataRequest $request) {
        $answers = [];
        foreach(self::QUESTIONS as $question_id => $question) {
            $answer = strval($request->get('question_'.$question_id));
            if(0 <= $answer && $answer <= count($question['a'])) {
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
