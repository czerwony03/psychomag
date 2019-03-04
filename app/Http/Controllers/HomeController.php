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
        return view('welcome');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    public function stroop()
    {
        // $user->tests()->save($test,["error"=>3,"attempts"=>10,"avg_time"=>1356,"min_time"=>500,"max_time"=>2000,"result"=>""]);
        return view('stroop');
    }
}
