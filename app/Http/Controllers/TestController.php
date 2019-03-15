<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function stroop(Request $request, $id)
    {
        $id = strval($id);
        if($id < 1 || $id > 4) {
            return response(null,404);
        }
        return view('tests.stroop.lvl'.$id);
    }
}
