<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollRequest;

class PollController extends Controller
{
    static $questions = [
        [
            "Nie jestem smutny ani przygnębiony.",
            "Odczuwam często smutek, przygnębienie.",
            "Przeżywam stale smutek, przygnębienie i nie mogę uwolnić się od tych przeżyć.",
            "Jestem stale tak smutny i nieszczęśliwy, że jest to nie do wytrzymania."
        ],
        [
            "Nie przejmuję się zbytnio przyszłością.",
            "Często martwię się o przyszłość.",
            "Obawiam się, że w przyszłości nic dobrego mnie nie czeka.",
            "Czuję, że przyszłość jest beznadziejna i nic tego nie zmieni."
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ],
        [
            "",
            "",
            "",
            ""
        ]
    ];
    public function poll_view() {
        return view('poll',["questions" => self::$questions]);
    }

    public function poll_send(PollRequest $request) {
        return view('poll',["questions" => self::$questions]);
    }
}
