<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Tester;
use Illuminate\Http\Request;

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
}
