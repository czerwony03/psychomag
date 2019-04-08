<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollPersonalDataRequest;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class PollPersonalDataController extends Controller
{
    const CODE = 'poll_personal_data';
    const QUESTIONS = [
        [
            "q" => "Płeć",
            "a" => [
                "Mężczyzna",
                "Kobieta"
            ]
        ], [
            "type" => "1",
            "q" => "Wiek",
            "a" => [
                "<18",
                "18",
                "19",
                "20",
                "21",
                "22",
                "23",
                "24",
                "25",
                "26",
                "27",
                "28",
                "29",
                "30",
                "31",
                "32",
                "33",
                "34",
                "35",
                ">35"
            ]
        ],
        [
            "q" => "Zażywam marihuanę",
            "a" => [
                "Tak",
                "Nie",
            ]
        ],
        [
            "q" => "Wykształcenie",
            "a" => [
                "Podstawowe",
                "Gimnazjalne",
                "Zawodowe",
                "Średnie",
                "Techniczne",
                "Wyższe",
            ]
        ],
        [
            "q" => "Stan cywilny",
            "a" => [
                "Panna / Kawaler",
                "W związku małżeńskim",
                "Rozwiedziony / Rozwiedziona",
                "Wdowiec / Wdowa",
            ]
        ],
        [
            "q" => "Miejsce zamieszkania",
            "a" => [
                "Wieś",
                "Miasto do 50 tys. Mieszkańców",
                "Miasto do 100 tys. Mieszkańców",
                "Miasto do 250 tys. Mieszkańców",
                "Miasto powyżej 250 tys. Mieszkańców",
            ]
        ],
        [
            "q" => "Zatrudnienie",
            "a" => [
                "Praca (stała/dorywcza)",
                "Nauka",
                "Praca i nauka",
                "Brak pracy i nauki",
                "Renta",
            ]
        ],
        [
            "type" => "2",
            "q" => "Zaznacz substancje (lub ich zamienniki), które zażywałaś / zażywałeś w ciągu ostatniego miesiąca",
            "a" => [
                "Alkohol",
                "Nikotyna",
                "Nadużywanie leków",
                "Dopalacze",
                "Amfetamina",
                "Metaamfetamina",
                "Heroina",
                "Kodeina",
                "Opium",
                "Morfina",
                "Kokaina",
                "Barbiturany",
                "Ketamina",
                "Benzodiazepiny",
                "Buprenorfina",
                "Substancje wziewne",
                "LSD",
                "Metylofenidat",
                "Anaboliki",
                "Ecstasy",
                "Grzyby halucynogenne",
                "Inne",
                "Nie zażywam",
            ]
        ]
    ];
    public function poll_view()
    {
        return view('polls.personal_data', ["questions" => self::QUESTIONS]);
    }

    public function poll_send(PollPersonalDataRequest $request)
    {
        $answers = [];
        foreach (self::QUESTIONS as $question_id => $question) {
            if (is_array($request->get('question_'.$question_id))) {
                $answers["question_".($question_id+1)]=$request->get('question_'.$question_id);
            } else {
                $answer = strval($request->get('question_'.$question_id));
                if (0 <= $answer && $answer <= count($question['a'])) {
                    $answers["question_".($question_id+1)]=$answer;
                }
            }
        }
        $poll = Test::where('code', '=', self::CODE)->first();
        $tester = $request->get('testerModel');
        $tester->save();
        $tester->tests()->save($poll, [
            'result'=>json_encode($answers),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);

        return redirect(route('test.next'));
    }
}
