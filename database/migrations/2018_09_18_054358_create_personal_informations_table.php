<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        "title":"Mr","gender":"M",,"passport":"dn","race":"Black","approx_height":"173","approx_mass","date_of_birth"

        Schema::create('personal_informations', function (Blueprint $table) {
            $table->integer('user_id', false, true)->index()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("title");
            $table->string('gender');
            $table->string("passport")->nullable();
            $table->string('marital_status');
            $table->integer("height")->nullable();
            $table->integer("mass")->nullable();
            $table->date("date_of_birth");
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
        Schema::dropIfExists('personal_informations');
    }
}
