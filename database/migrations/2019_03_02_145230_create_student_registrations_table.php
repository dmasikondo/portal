<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("student_enrolment_id");
            $table->integer("registration_period_id");
            $table->integer("level");
            $table->integer("term");
            $table->timestamps();
        });

        Schema::table('intake', function (Blueprint $table) {
            $table->integer("length")->default(1);
            $table->string("length_unit")->default("years");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intake', function (Blueprint $table) {
            $table->dropColumn(["length", "length_unit"]);
        });

        Schema::dropIfExists('student_registrations');
    }
}
