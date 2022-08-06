<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOriginInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origin_informations', function (Blueprint $table) {
            $table->integer('user_id', false, true)->index()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("nationality");
            $table->string("birth_country");
            $table->string("birth_town");
            $table->string("hometown");
            $table->string("race");
            $table->string("religion");
            $table->string("denomination");
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
        Schema::dropIfExists('origin_informations');
    }
}
