<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSECertificateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_e_certificate_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certificate_id', false, true)->index();
            $table->foreign('certificate_id')->references('id')->on('secondary_exam_certificates')->onDelete("cascade")->onUpdate("cascade");
            $table->string('subject');
            $table->string('grade');
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
        Schema::dropIfExists('s_e_certificate_results');
    }
}
