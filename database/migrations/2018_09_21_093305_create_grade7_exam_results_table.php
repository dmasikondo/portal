<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrade7ExamResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade7_exam_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('grade7_exam_centre_id', false, true)->index();
            $table->foreign('grade7_exam_centre_id')->references('id')->on('grade7_exam_centres')->onDelete("cascade")->onUpdate("cascade");
            $table->string("subject")->nullable();
            $table->integer("points");
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
        Schema::dropIfExists('grade7_exam_results');
    }
}
