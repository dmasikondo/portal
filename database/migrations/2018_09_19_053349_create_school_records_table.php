<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("name");
            $table->enum('school_type', ["P", "S"]);
            $table->string("from_year");
            $table->string("to_year");
            $table->integer("from_level");
            $table->integer("to_level");
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
        Schema::dropIfExists('school_records');
    }
}
