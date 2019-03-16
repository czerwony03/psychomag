<?php

use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tests')->delete();
        DB::table('tests')->insert([
                [
                    'name' => 'Ankieta - Depresja',
                    'code' => 'poll'
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 1',
                    'code' => Test::TEST_STROOP_1
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 2',
                    'code' => Test::TEST_STROOP_2
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 3',
                    'code' => Test::TEST_STROOP_3
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 4',
                    'code' => Test::TEST_STROOP_4
                ],
                [
                    'name' => 'TMT ver A',
                    'code' => Test::TEST_TMT_A
                ],
                [
                    'name' => 'TMT ver B',
                    'code' => Test::TEST_TMT_B
                ],
                [
                    'name' => 'GO / NO GO ver 1',
                    'code' => Test::TEST_GO_NOGO_1
                ],
                [
                    'name' => 'GO / NO GO ver 2',
                    'code' => Test::TEST_GO_NOGO_2
                ],
                [
                    'name' => 'Wisconsin Card Sorting Test',
                    'code' => Test::TEST_WCST
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
