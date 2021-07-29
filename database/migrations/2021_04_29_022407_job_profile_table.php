<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JobProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('job_id')->unsigned();
            $table->unsignedBigInteger('profile_id')->unsigned();
            $table->timestamps();
            
            $table->primary(['job_id','profile_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
