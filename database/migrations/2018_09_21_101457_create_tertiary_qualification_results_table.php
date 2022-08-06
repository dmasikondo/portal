<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTertiaryQualificationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tertiary_qualification_period', function (Blueprint $table) {
            $table->bigInteger('id', true, true);
            $table->integer('tertiary_qualification_id', false, true)->index();
            $table->foreign('tertiary_qualification_id')->references('id')
                ->on('tertiary_qualifications')->onDelete("cascade")->onUpdate("cascade");
            $table->string("period");
            $table->integer("number_of_courses");
        });

        Schema::create('tertiary_qualification_results', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('tertiary_qualification_period_id', false, true)->index();
            $table->foreign('tertiary_qualification_period_id')->references('id')
                ->on('tertiary_qualification_period')->onDelete("cascade")->onUpdate("cascade");
            $table->string("module");
            $table->string("grade");
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
        Schema::dropIfExists('tertiary_qualification_results');
        Schema::dropIfExists('tertiary_qualification_period');
    }
}
