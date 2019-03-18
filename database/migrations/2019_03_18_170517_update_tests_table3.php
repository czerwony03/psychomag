<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateTestsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('tests')->insert([
            [
                'name' => 'Ankieta - PUM',
                'code' => \App\Http\Controllers\PollPumController::CODE,
                'order' => (\App\Models\Test::all()->count()+1)
            ],
            [
                'name' => 'Ankieta - metryczka',
                'code' => 'poll_personal_data',
                'order' => (\App\Models\Test::all()->count()+2)
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
