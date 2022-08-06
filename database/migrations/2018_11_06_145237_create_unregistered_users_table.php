<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnregisteredUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unregistered_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string("first_name");
            $table->string("surname");
            $table->string("national_id");
            $table->string("student_id");
            $table->string("email");
            $table->string("phone")->nullable();
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
        Schema::dropIfExists('unregistered_users');
    }
}
