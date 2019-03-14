<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pages.welcome');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('pages.home');
    }

    public function stroop1()
    {
        return view('tests.stroop.lvl1');
    }

    public function stroop2()
    {
        return view('tests.stroop.lvl2');
    }

    public function stroop3()
    {
        return view('tests.stroop.lvl3');
    }

    public function stroop4()
    {
        return view('tests.stroop.lvl4');
    }

    public function tmtA() {
        return view('tests.tmt',["ver"=>"A"]);
    }

    public function tmtB() {
        return view('tests.tmt',["ver"=>"B"]);
    }

    public function go_nogo_one() {
        return view('tests.go_nogo.one');
    }

    public function go_nogo_two() {
        return view('tests.go_nogo.two');
    }

    public function wcst() {
        return view('tests.wcst');
    }
}
