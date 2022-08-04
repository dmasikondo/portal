<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_enrolment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid', false, true)->index();
            $table->foreign('userid')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->bigInteger('programmeid', false)->index();
            $table->foreign('programmeid')->references('id')->on('programme')->onDelete("cascade")->onUpdate("cascade");
            $table->bigInteger('qualificationid', false)->index();
            $table->foreign('qualificationid')->references('id')->on('qualification')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('student_enrolment');
    }
}
