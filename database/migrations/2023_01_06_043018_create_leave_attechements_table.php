<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveAttechementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_attechements', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_id');
            $table->integer('attechement_type_id');
            $table->string('upload_document');
            $table->string('location_latitude');
            $table->string('location_longitude');
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
        Schema::dropIfExists('leave_attechements');
    }
}
