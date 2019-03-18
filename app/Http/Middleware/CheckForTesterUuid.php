<?php

namespace App\Http\Middleware;

use App\Models\Tester;
use Closure;

class CheckForTesterUuid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $hasTester = false;
        if(session()->has('tester_uuid')) {
            $tester = Tester::where('uuid','=',session()->get('tester_uuid'))->first();
            if($tester instanceof Tester) {
                $hasTester = true;
                $request->attributes->add(['testerModel' => $tester]);
            }
        }
        if($hasTester) {
            return $next($request);
        } else {
            return redirect(route('poll_view'));
        }
    }
}
