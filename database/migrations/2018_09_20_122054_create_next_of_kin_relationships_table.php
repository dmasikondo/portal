<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextOfKinRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_of_kin_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
        });

        $relation = array(
            array('title' => 'Father'),
            array('title' => 'Mother'),
            array('title' => 'Brother'),
            array('title' => 'Sister'),
            array('title' => "Uncle(Father's Brother)"),
            array('title' => 'Uncle(Mother\'s Brother)'),
            array('title' => 'Aunt(Father\'s Sister)'),
            array('title' => 'Aunt(Mother\'s Sister)'),
            array('title' => 'GrandFather(Martenal)'),
            array('title' => 'GrandFather(Paternal)'),
            array('title' => 'GrandMother(Martenal)'),
            array('title' => 'GrandMother(Paternal)'),
            array('title' => 'Cousin(Paternal)'),
            array('title' => 'Cousin(Martenal)'),
            array('title' => 'Husband'),
            array('title' => 'Wife'),
            array('title' => 'Daughter'),
            array('title' => 'Son'),
            array('title' => 'Friend'),
            array('title' => 'Non-relative Guardian'),
        );
        DB::table("next_of_kin_relationships")->insert($relation);

        Schema::table("next_of_kin_informations", function (Blueprint $table) {
            $table->integer("next_of_kin_relationship_id", false, true)
                ->index()->nullable()->after('name');
            $table->foreign('next_of_kin_relationship_id')
                ->references("id")->on('next_of_kin_relationships')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->string('national_id')->after('next_of_kin_relationship_id');
            $table->dropColumn('relationship');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('next_of_kin_relationships');
        Schema::table("next_of_kin_informations", function (Blueprint $table) {
            $table->dropColumn('next_of_kin_relationship_id');
            $table->string("relationship");
        });
    }
}
