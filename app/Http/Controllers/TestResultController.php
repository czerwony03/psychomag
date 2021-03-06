<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestResultController extends Controller
{
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_code' => 'required|exists:tests,code',
            'test_result' => 'required|json',
        ]);

        if ($validator->fails()) {
            return response('Wystąpił błąd podczas zapisu danych!', 403);
        }

        $test = Test::where('code', '=', $request->get('test_code'))->first();
        $tester = $request->get('testerModel');
        $tester->tests()->save($test, [
            'result'=>$request->get('test_result'),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);
        $tester->touch();

        return response()->redirectTo(route('test.next'));
    }

    public function next(Request $request)
    {
        $tests = Test::all();
        $tester = $request->get('testerModel');
        $nextTest = Test::where('order', '>', $tester->tests->sortBy('order')->last()->order)->orderBy('order')->first();
        if (!$nextTest instanceof Test && $tester->tests->count()<$tests->count()) {
            return response('Wystąpił błąd podczas wyświetlania kolejnego testu!', 403);
        } elseif (!$nextTest instanceof Test && $tester->tests->count()>=$tests->count()) {
            return response()->redirectTo(route('test.finish'));
        } else {
            $testView = 'tests.';
            $testViewVariables = [
                "test_code" => $nextTest->code,
                "ver" => '',
                "prepare" => false,
            ];
            switch ($nextTest->code) {
                case Test::TEST_STROOP_1:
                    $testView.='stroop.lvl1';
                    break;
                case Test::TEST_STROOP_2:
                    $testView.='stroop.lvl2';
                    break;
                case Test::TEST_STROOP_3:
                    $testView.='stroop.lvl3';
                    break;
                case Test::TEST_STROOP_4:
                    $testView.='stroop.lvl4';
                    break;
                case Test::TEST_TMT_A_PREPARE:
                    $testView.='tmt';
                    $testViewVariables["ver"]='A';
                    $testViewVariables["prepare"]=true;
                    break;
                case Test::TEST_TMT_A:
                    $testView.='tmt';
                    $testViewVariables["ver"]='A';
                    break;
                case Test::TEST_TMT_B_PREPARE:
                    $testView.='tmt';
                    $testViewVariables["ver"]='B';
                    $testViewVariables["prepare"]=true;
                    break;
                case Test::TEST_TMT_B:
                    $testView.='tmt';
                    $testViewVariables["ver"]='B';
                    break;
                case Test::TEST_GO_NOGO_1:
                    $testView.='go_nogo.one';
                    break;
                case Test::TEST_GO_NOGO_2:
                    $testView.='go_nogo.two';
                    break;
                case Test::TEST_WCST:
                    $testView.='wcst';
                    break;
                case PollPumController::CODE:
                    return response()->redirectTo(route('poll_pum_view'));
                    break;
                case PollPersonalDataController::CODE:
                    return response()->redirectTo(route('poll_personal_data_view'));
                    break;
                default:
                    return response('Wystąpił błąd podczas wyświetlania kolejnego testu!', 403);
            }
            return response()->view($testView, $testViewVariables);
        }
    }

    public function finish(Request $request)
    {
        $tester = $request->get('testerModel');
        $testsResults = $tester->tests->sortBy('pivot.test_id');
        $tests=Test::all();
        return response()->view('tests.finish', compact('tester', 'testsResults', 'tests'));
    }
}
