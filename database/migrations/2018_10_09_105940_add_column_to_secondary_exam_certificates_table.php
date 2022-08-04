<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSecondaryExamCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('secondary_exam_certificates', function (Blueprint $table) {
            $table->integer('number_of_subjects')->after('candidate_number')->default("1");
        });

        Schema::create("secondary_subject_list", function (Blueprint $table) {
            $table->bigInteger("id", true, true);
            $table->string("level");
            $table->string("board");
            $table->string("subject");
            $table->integer("is_approved")->default("0");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("secondary_subject_list");
        Schema::table('secondary_exam_certificates', function (Blueprint $table) {
            $table->dropColumn('number_of_subjects');
        });
    }
}
