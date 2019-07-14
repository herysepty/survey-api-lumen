<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respondents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('address');
            $table->string('gender');
            $table->string('hamlet'); // rw
            $table->string('neighbourhood'); //rt
            $table->string('urban_village'); //urban village
            $table->string('sub_district'); //sub-district
            $table->string('district'); //Kabupaten
            $table->string('province'); // provinsi
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
        Schema::drop('respondents');
    }
}
