<?php

namespace App\Exports;

use App\Http\Controllers\PollDepressionController;
use App\Http\Controllers\PollPersonalDataController;
use App\Http\Controllers\PollPumController;
use App\Models\Test;
use App\Models\Tester;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tester::with([
            'tests' => function ($query) {
                $query->orderBy('test_id');
            }
        ])->has('tests', '=', 14)->get();
    }

    public function headings(): array
    {
        $headings = [
            '#',
            'UUID',
            'Utworzony',
            'Aktualizacja',
            PollDepressionController::CODE,
            "Dep_Suma",
            Test::TEST_STROOP_1,
            "S1_Attempts",
            "S1_Errors",
            "S1_AvgTime",
            Test::TEST_STROOP_2,
            "S2_Attempts",
            "S2_Errors",
            "S2_AvgTime",
            Test::TEST_STROOP_3,
            "S3_Attempts",
            "S3_Errors",
            "S3_AvgTime",
            Test::TEST_STROOP_4,
            "S4_Attempts",
            "S4_Errors",
            "S4_AvgTime",
            Test::TEST_TMT_A,
            "TA_Errors",
            "TA_OK",
            "TA_Time",
            Test::TEST_TMT_B,
            "TB_Errors",
            "TB_OK",
            "TB_Time",
            Test::TEST_GO_NOGO_1,
            "GN1_Attempts",
            "GN1_Errors",
            "GN1_AvgTime",
            Test::TEST_GO_NOGO_2,
            "GN2_Attempts",
            "GN2_Errors",
            "GN2_AvgTime",
            Test::TEST_WCST,
            "WCST_Attempts",
            "WCST_Errors",
            "WCST_RepeatedErrors",
            "WCST_CompletedDecks"
        ];
        $headings[] = PollPumController::CODE;
        foreach (PollPumController::$questions as $question) {
            $headings[] = $question;
        }

        $headings[] = PollPersonalDataController::CODE;
        foreach (PollPersonalDataController::QUESTIONS as $question) {
            if (empty($question["type"]) || $question["type"] != 2) {
                $headings[] = $question["q"];
            } else {
                foreach ($question["a"] as $answer) {
                    $headings[] = $answer;
                }
            }
        }

        return $headings;
    }

    public function map($tester): array
    {
        $row = [
            $tester->id,
            $tester->uuid,
            $tester->created_at,
            $tester->updated_at,
        ];
        /** @var Test $test */
        foreach ($tester->tests as $test) {
            $result = json_decode($test->pivot->result, false);
            if (!in_array($test->code,[Test::TEST_TMT_A_PREPARE, Test::TEST_TMT_B_PREPARE])) {
                $row[] = $test->code;
            }
            switch ($test->code) {
                case PollDepressionController::CODE:
                    $row[] = ($result->poll_sum ? $result->poll_sum : "0");
                    break;
                case Test::TEST_STROOP_1:
                case Test::TEST_STROOP_2:
                case Test::TEST_STROOP_3:
                case Test::TEST_STROOP_4:
                    $row[] = ($result->attempts ? $result->attempts : "0");
                    $row[] = ($result->errors ? $result->errors : "0");
                    $row[] = ($result->avg_time ? $result->avg_time : "0");
                    break;
                case Test::TEST_TMT_A:
                case Test::TEST_TMT_B:
                    $row[] = ($result->errors ? $result->errors : "0");
                    $row[] = ($result->ok ? $result->ok : "0");
                    $row[] = ($result->time ? $result->time : "0");
                    break;
                case Test::TEST_GO_NOGO_1:
                case Test::TEST_GO_NOGO_2:
                    $row[] = ($result->attempts ? $result->attempts : "0");
                    $row[] = ($result->errors ? $result->errors : "0");
                    $row[] = ($result->avg_time ? $result->avg_time : "0");
                    break;
                case Test::TEST_WCST:
                    $row[] = ($result->attempts ? $result->attempts : "0");
                    $row[] = ($result->errors ? $result->errors : "0");
                    $row[] = ($result->repeated_errors ? $result->repeated_errors : "0");
                    $row[] = ($result->completed_decks ? $result->completed_decks : "0");
                    break;
                case PollPumController::CODE:
                    foreach ($result as $answerId) {
                        $row[] = PollPumController::$answers[($answerId-1)];
                    }
                    break;
                case PollPersonalDataController::CODE:
                    $key = 0;
                    foreach ($result as $answer) {
                        if (empty(PollPersonalDataController::QUESTIONS[$key]['type']) || PollPersonalDataController::QUESTIONS[$key]['type'] != 2) {
                            $row[] = PollPersonalDataController::QUESTIONS[$key]['a'][$answer];
                        } else {
                            
                        }
                        $key ++;
                    }
                    break;
                case Test::TEST_TMT_A_PREPARE:
                case Test::TEST_TMT_B_PREPARE:
                    break;
                default:
                    $row[] = 'Wystąpił błąd!';
            }
        }
        return $row;
    }
}
