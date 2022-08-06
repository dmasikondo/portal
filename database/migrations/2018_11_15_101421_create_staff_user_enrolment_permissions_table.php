<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffUserEnrolmentPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_users', function (Blueprint $table) {
            $table->string('user_type')->after('password');
        });

        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->string('phone_number')->after('mode_of_entry');
            $table->string("house_number")->after("phone_number");
            $table->string("street_name")->after("house_number");
            $table->string("suburb")->after("street_name");
            $table->string("city")->after("suburb");
            $table->string("country")->after("city");
            $table->integer('added_by', false, true)->index()->after("country");
            $table->foreign('added_by')->references('id')->on('staff_users')->onDelete("cascade")->onUpdate("cascade");
        });


        Schema::create('staff_user_enrolment_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_user_id', false, true)->index();
            $table->foreign('staff_user_id')->references('id')->on('staff_users')->onDelete("cascade")->onUpdate("cascade");
            $table->bigInteger('department_id')->index();
            $table->foreign('department_id')->references('id')->on('department')->onDelete("cascade")->onUpdate("cascade");
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
        Schema::dropIfExists('staff_user_enrolment_permissions');
        Schema::table('base_enrolled_students', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
            $table->dropColumn(["phone_number", "house_number", "street_name", "suburb", "city", "country", "added_by"]);
        });
        Schema::table("staff_users", function (Blueprint $table) {
            $table->dropColumn(["user_type"]);
        });
    }
}
