<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistrictMaidenColumnsToEnrolmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->string("maiden_name", 50)->after("last_name")->nullable();
            $table->string("district", 50)->after("city")->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string("maiden_name", 50)->after("last_name")->nullable();
        });

        Schema::table("contact_informations", function (Blueprint $table) {
            $table->string("district", 50)->after("city")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->dropColumn(["maiden_name", "district"]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["maiden_name"]);
        });

        Schema::table("contact_informations", function (Blueprint $table) {
            $table->dropColumn(["district"]);
        });
    }
}
