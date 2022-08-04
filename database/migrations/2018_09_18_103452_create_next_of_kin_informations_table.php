<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextOfKinInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_of_kin_informations', function (Blueprint $table) {
            $table->integer('user_id', false, true)->index()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("name");
            $table->string("relationship");
            $table->string("cellphone");
            $table->string("email");
            $table->string("house_number");
            $table->string("street_name");
            $table->string("suburb");
            $table->string("city");
            $table->string("country");
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
        Schema::dropIfExists('next_of_kin_informations');
    }
}
