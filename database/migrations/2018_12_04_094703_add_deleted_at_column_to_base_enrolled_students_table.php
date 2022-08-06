<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtColumnToBaseEnrolledStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->timestamp('deleted_at', 0)->nullable();
        });

        Schema::create('base_enrolled_student_deletions', function (Blueprint $table) {
            $table->integer('staff_user_id', false, true)->index()->nullable();
            $table->foreign('staff_user_id')->references('id')->on('staff_users')->onDelete("SET NULL")->onUpdate("cascade");
            $table->integer('base_enrolled_student_id', false, true)->index();
            $table->foreign('base_enrolled_student_id')->references('id')->on('base_enrolled_students')
                ->onDelete("cascade")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("base_enrolled_student_deletions");

        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
