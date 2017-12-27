<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_visits', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('session_id');
            $table->string('ip', 15)->nullable();
            $table->dateTime('visit_time');
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();
            $table->text('request_uri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_visits');
    }
}
