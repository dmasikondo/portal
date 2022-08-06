<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNextOfKinTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('next_of_kin_informations', function (Blueprint $table) {
            $table->string('title')->after("user_id")->nullable();
            $table->string('surname')->after("name")->nullable();
            $table->string('gender')->after("next_of_kin_relationship_id")->nullable();
            $table->date("date_of_birth")->after('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('next_of_kin_informations', function (Blueprint $table) {
            $table->dropColumn(['title', 'surname', 'gender', "date_of_birth"]);
        });
    }
}
