<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseEnrolledStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        'title', 'first_name', 'surname', 'gender', 'date_of_birth',
//        'national_id', "qualification_id", "course_id", "mode_of_entry"
        Schema::create('base_enrolled_students', function (Blueprint $table) {
            $table->increments('id');
            $table->string("student_no");
            $table->string("title");
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id')->unique();
            $table->string('gender');
            $table->date("date_of_birth");
            $table->bigInteger('programmeid', false)->index();
            $table->foreign('programmeid')->references('id')->on('programme')->onDelete("cascade")->onUpdate("cascade");
            $table->bigInteger('qualificationid', false)->index();
            $table->foreign('qualificationid')->references('id')->on('qualification')->onDelete("cascade")->onUpdate("cascade");
            $table->string('mode_of_entry');
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
        Schema::dropIfExists('base_enrolled_students');
    }
}
