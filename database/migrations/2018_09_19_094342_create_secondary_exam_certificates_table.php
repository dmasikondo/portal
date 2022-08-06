<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecondaryExamCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secondary_exam_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string('result_month')->nullable();
            $table->string('result_year')->nullable();
            $table->string('examining_body')->nullable();
            $table->enum('level', ["O", "A"]);
            $table->string('certificate_number');
            $table->string('center_number');
            $table->string('candidate_number');
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
        Schema::dropIfExists('secondary_exam_certificates');
    }
}
