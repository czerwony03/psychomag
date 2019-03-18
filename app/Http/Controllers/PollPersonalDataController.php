<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollPersonalDataRequest;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class PollPersonalDataController extends Controller
{
    const CODE = 'poll_personal_data';

    public function poll_view() {
        return '';//view('polls.pum',["questions" => self::$questions,"answers" => self::$answers]);
    }

    public function poll_send(PollPersonalDataRequest $request) {
        $answers = [];
        /*foreach(self::$questions as $question_id => $question) {
            $answer = strval($request->get('question_'.$question_id));
            if(1 <= $answer && $answer <= 5) {
                $answers["question_".($question_id+1)]=$answer;
            }
        }*/
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
