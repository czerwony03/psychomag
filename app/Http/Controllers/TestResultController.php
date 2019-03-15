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
            return response('Wystąpił błąd podczas zapisu danych!',403);
        }

        $test = Test::where('code','=',$request->get('test_code'))->first();
        $tester = $request->testerModel;
        $tester->tests()->save($test,[
            'result'=>$request->get('test_result'),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);

        return response()->redirectTo(route('test.next'));
    }

    public function next(Request $request)
    {
        $tests = Test::all();
        $tester = $request->testerModel;
        $nextTest = Test::where('id','>',$tester->tests->sortBy('pivot.test_id')->last()->id)->first();
        if(!$nextTest instanceof Test && $tester->tests->count()<$tests->count()) {
            return response('Wystąpił błąd podczas wyświetlania kolejnego testu!',403);
        } else if(!$nextTest instanceof Test && $tester->tests->count()>=$tests->count()) {
            return response('Strona finałowa nie została jeszcze przygotowana',404);
        } else {
            $testView = 'tests.';
            $testViewVariables = [];
            switch($nextTest->code) {
                case 'stroop1':
                    $testView.='stroop.lvl1';
                    break;
                case 'stroop2':
                    $testView.='stroop.lvl2';
                    break;
                case 'stroop3':
                    $testView.='stroop.lvl3';
                    break;
                case 'stroop4':
                    $testView.='stroop.lvl4';
                    break;
                case 'tmt_a':
                    $testView.='tmt';
                    $testViewVariables["ver"]='A';
                    break;
                case 'tmt_b':
                    $testView.='tmt';
                    $testViewVariables["ver"]='B';
                    break;
                case 'go_nogo1':
                    $testView.='go_nogo.one';
                    break;
                case 'go_nogo2':
                    $testView.='go_nogo.two';
                    break;
                case 'wcst':
                    $testView.='wcst';
                    break;
                default:
                    return response('Wystąpił błąd podczas wyświetlania kolejnego testu!',403);
            }
            return response()->view($testView,$testViewVariables);
        }
    }
}
