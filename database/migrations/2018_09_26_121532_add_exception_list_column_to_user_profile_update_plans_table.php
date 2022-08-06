<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExceptionListColumnToUserProfileUpdatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile_update_plans', function (Blueprint $table) {
            $table->text("exception_routes")->after("status");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile_update_plans', function (Blueprint $table) {
            $table->dropColumn("exception_routes");
        });
    }
}
