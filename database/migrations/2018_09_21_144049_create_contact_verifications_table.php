<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_verifications', function (Blueprint $table) {
            $table->integer('user_id', false, true)->index()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("mobile_token")->nullable();
            $table->timestamp('sms_verified_at')->nullable();
            $table->timestamps();

        });
        Schema::create('email_verifications', function (Blueprint $table) {
            $table->integer('user_id', false, true)->index()->primary();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->string("email_code")->nullable();
            $table->string("email_token")->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('email_verifications');
        Schema::dropIfExists('contact_verifications');
    }
}
