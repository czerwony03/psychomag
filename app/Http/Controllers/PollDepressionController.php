<?php

namespace App\Http\Controllers;

use App\Http\Requests\PollDepressionRequest;
use App\Models\Test;
use App\Models\Tester;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PollDepressionController extends Controller
{
    const CODE = 'poll_depression';
    public static $questions = [
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
            "Sądzę że nie popełniam większych zaniedbań.",
            "Sądzę że czynię więcej zaniedbań niż inni",
            "Kiedy spoglądam na to co robiłem, widzę mnóstwo błędów i zaniedbań.",
            "Jestem zupełnie niewydolny i wszystko robię źle."
        ],
        [
            "To co robie sprawia mi przyjemność.",
            "Nie cieszy mnie to co robię.",
            "Nic mi teraz nie daje prawdziwego zadowolenia.",
            "Nie potrafię przeżywać zadowolenia i przyjemności i wszystko mnie nuży."
        ],
        [
            "Nie czuję się winnym ani wobec siebie ani wobec innych.",
            "Dość często miewam wyrzuty sumienia.",
            "Często czuję że zawiniłem.",
            "Stale czuję się winnym."
        ],
        [
            "Sądzę że nie zasługuję na karę.",
            "Sądzę że zasługuję na karę.",
            "Spodziewam się ukarania.",
            "Wiem że jestem karany (lub ukarany)."
        ],
        [
            "Jestem z siebie zadowolony.",
            "Nie jestem z siebie zadowolony.",
            "Czuję do siebie niechęć.",
            "Nienawidzę siebie."
        ],
        [
            "Nie czuję się gorszy od innych.",
            "Zarzucam sobie że jestem nieudolny i popełniam błędy.",
            "Stale potępiam siebie za popełnione błędy.",
            "Winie siebie za wszystko zło które istnieje."
        ],
        [
            "Nie myślę o odebraniu sobie życia.",
            "Myślę o samobójstwie - ale nie mógłbym tego dokonać.",
            "Pragnę odebrać sobie życie.",
            "Popełnię samobójstwo jak będzie odpowiednia sposobność."
        ],
        [
            "Nie płaczę częściej niż zwykle.",
            "Płaczę częściej niż dawniej.",
            "Ciągle chce mi się płakać.",
            "Chciałbym płakać lecz nie jestem w stanie."
        ],
        [
            "Nie jestem bardziej podenerwowany niż dawniej.",
            "Jestem bardziej nerwowy i przykry niz dawniej.",
            "Jestem stale nerwowy i rozdrażniony.",
            "Wszystko co dawniej mnie drażniło stało się obojętne."
        ],
        [
            "Ludzie interesują mnie jak dawniej.",
            "Interesuje się ludźmi mniej niż dawniej.",
            "Utraciłem większość zainteresowań innymi ludźmi.",
            "Utraciłem wszelkie zainteresowania innymi ludźmi."
        ],
        [
            "Decyzje podejmuję łatwo tak jak dawniej.",
            "Częściej niż kiedyś odwlekam podjęcie decyzji.",
            "Mam dużo trudności z podjęciem decyzji.",
            "Nie jestem w stanie podjąć żadnej decyzji."
        ],
        [
            "Sądzę że wyglądam nie gorzej niż dawniej.",
            "Martwię się tym że wyglądam staro i nieatrakcyjnie.",
            "Czuję że wyglądam coraz gorzej.",
            "Jestem przekonany że wyglądam okropnie i odpychająco."
        ],
        [
            "Mogę pracować tak jak dawniej.",
            "Z trudem rozpoczynam każdą czynność.",
            "Z wielkim wysiłkiem zmuszam się do zrobienia czegokolwiek.",
            "Nie jestem w stanie nic robić."
        ],
        [
            "Sypiam dobrze jak zwykle.",
            "Sypiam gorzej niż dawniej.",
            "Rano budzę się 1 - 2 godziny za wcześnie i trudno jest mi ponownie usnąć.",
            "Budzę się kilka godzin za wcześnie i nie mogę usnąć."
        ],
        [
            "Nie męczę się bardziej niż dawniej.",
            "Męczę się znacznie łatwiej niż poprzednio.",
            "Męczę się wszystkim co robię.",
            "Jestem zbyt zmęczony aby cokolwiek robić."
        ],
        [
            "Mam apetyt nie gorszy niż dawniej.",
            "Mam trochę gorszy apetyt.",
            "Apetyt mam wyraźnie gorszy.",
            "Nie mam w ogóle apetytu."
        ],
        [
            "Nie tracę na wadze ciała ( w okresie ostatniego miesiąca).",
            "Straciłem na wadze więcej niż 2 kg.",
            "Straciłem na wadze więcej niż 4 kg.",
            "Straciłem na wadze więcej niż 6 kg."

        ],
        [
            "Nie martwię się o swoje zdrowie bardziej niż zawsze.",
            "Martwię się swoimi dolegliwościami, mam rozstrój żołądka, zaparcia, bóle.",
            "Stan mego zdrowia bardzo mnie martwi często o tym myślę.",
            "Tak bardzo martwię się o swoje zdrowie że nie mogę o niczym innym myśleć."
        ],
        [
            "Moje zainteresowania seksualne nie uległy zmianom.",
            "Jestem mniej zainteresowany sprawami płci (seksu).",
            "Problemy płciowe wyraźnie mnie nie interesują.",
            "Utraciłem wszelkie zainteresowania sprawami seksualnymi."
        ]
    ];
    public function poll_view()
    {
        return view('polls.depression', ["questions" => self::$questions]);
    }

    public function poll_send(PollDepressionRequest $request)
    {
        $pollSum = 0;
        foreach (self::$questions as $question_id => $question) {
            $answer = strval($request->get('question_'.$question_id));
            if (0 <= $answer && $answer <= 3) {
                $pollSum+=$answer;
            }
        }
        $result = [
            "poll_sum" => $pollSum
        ];
        $poll = Test::where('code', '=', self::CODE)->first();
        $tester = new Tester();
        $tester->save();
        $tester->tests()->save($poll, [
            'result'=>json_encode($result),
            'created_at'=>DB::raw('CURRENT_TIMESTAMP'),
            'updated_at'=>DB::raw('CURRENT_TIMESTAMP')
        ]);

        Session::put('tester_uuid', $tester->uuid);

        return redirect(route('test.next'));
    }
}
