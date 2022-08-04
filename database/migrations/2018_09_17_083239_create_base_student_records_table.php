<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseStudentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_student_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string("DCLink");
            $table->string("Account");
            $table->string("Name");
            $table->string("Telephone")->nullable();
            $table->string("DCBalance");
            $table->string("ucARSTUDENTNO");
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
        Schema::dropIfExists('base_student_records');
    }
}
