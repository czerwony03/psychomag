<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_tester', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tester_id');
            $table->foreign('tester_id')->references('id')->on('testers');
            $table->unsignedInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->text('result');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_tester');
    }
}
