<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyleaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencyleave', function (Blueprint $table) {
            $table->id();
            $table->string('leave_type');
            $table->string('reason');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('upload_document');
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
        Schema::dropIfExists('emergencyleave');
    }
}
