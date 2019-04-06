<?php

use Illuminate\Support\Facades\DB;
use App\Models\Test;
use Illuminate\Database\Migrations\Migration;

class AddTmtPrepareTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('UPDATE `tests` SET `order` = `order` + 1 WHERE `order` >= 6;');
        DB::statement('UPDATE `tests` SET `order` = `order` + 1 WHERE `order` >= 8;');
        DB::table('tests')->insert([
            [
                'name' => 'TMT ver A - Próbny',
                'code' => Test::TEST_TMT_A_PREPARE,
                'order' => 6
            ],
            [
                'name' => 'TMT ver B - Próbny',
                'code' => Test::TEST_TMT_B_PREPARE,
                'order' => 8
            ]
        ]);
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
