<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
                    'name' => 'Ankieta',
                    'code' => 'poll'
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 1',
                    'code' => 'stroop1'
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 2',
                    'code' => 'stroop2'
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 3',
                    'code' => 'stroop3'
                ],
                [
                    'name' => 'Test kolorów stroop\'a - LVL 4',
                    'code' => 'stroop4'
                ],
                [
                    'name' => 'TMT ver A',
                    'code' => 'tmt_a'
                ],
                [
                    'name' => 'TMT ver B',
                    'code' => 'tmt_b'
                ],
                [
                    'name' => 'GO / NO GO ver 1',
                    'code' => 'go_nogo1'
                ],
                [
                    'name' => 'GO / NO GO ver 2',
                    'code' => 'go_nogo2'
                ],
                [
                    'name' => 'Wisconsin Card Sorting Test',
                    'code' => 'wcst'
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
