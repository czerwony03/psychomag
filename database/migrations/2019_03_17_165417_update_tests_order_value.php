<?php

use App\Models\Test;
use Illuminate\Database\Migrations\Migration;

class UpdateTestsOrderValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tests = Test::all();
        $order = 0;
        foreach ($tests as $test) {
            $order++;
            $test->order = $order;
            $test->save();
        }
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
