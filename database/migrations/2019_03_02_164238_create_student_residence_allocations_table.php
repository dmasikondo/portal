<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResidenceAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_residence_allocations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id");
            $table->integer("bed_id");
            $table->integer("residence_space_id", false, true);
            $table->dateTime("allocation_date");
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
        Schema::dropIfExists('student_residence_allocations');
    }
}
