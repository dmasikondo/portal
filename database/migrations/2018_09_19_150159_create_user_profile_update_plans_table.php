<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileUpdatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile_update_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true)->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->integer("stage");
            $table->integer("total_stages");
            $table->string("route");
            $table->enum("status", ["P", "A", "C"])->default("P");
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
        Schema::dropIfExists('user_profile_update_plans');
    }
}
