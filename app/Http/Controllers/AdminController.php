<?php

namespace App\Http\Controllers;

use App\Exports\TestersExport;
use App\Models\Test;
use App\Models\Tester;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function objects()
    {
        $testers=Tester::all()->sortByDesc('id');
        $tests=Test::all();
        return response()->view('pages.auth.objects', compact('testers', 'tests'));
    }

    public function objects_ganja()
    {
        $testers=Tester::whereHas('tests', function ($query) {
            $query->where('tests.code', '=', PollPersonalDataController::CODE);
            $query->where('test_tester.result', 'LIKE', '%"question_3":"0"%');
        })->get();
        $tests=Test::all();
        return response()->view('pages.auth.objects', compact('testers', 'tests'));
    }

    public function objectResult($id)
    {
        $tester = Tester::find($id);
        if (!$tester instanceof Tester) {
            return response('', 404);
        }
        $testsResults = $tester->tests->sortBy('pivot.test_id');
        $tests=Test::all();
        return response()->view('tests.finish', compact('tester', 'testsResults', 'tests'));
    }

    public function resultsDownload()
    {
        /*ini_set('xdebug.var_display_max_depth', '10');
        ini_set('xdebug.var_display_max_children', '256');
        ini_set('xdebug.var_display_max_data', '1024');

        $tests=Test::all();
        $testers=Tester::with(['tests' => function ($query) {
            $query->orderBy('test_id');
        }])->get();

        foreach ($testers as $tester) {
            if ($tester->tests->count()>=$tests->count()) {

                var_dump($tester);
                die();
            }
        }*/

        return Excel::download(new TestersExport(), 'results.xlsx', null, []);
    }
}
