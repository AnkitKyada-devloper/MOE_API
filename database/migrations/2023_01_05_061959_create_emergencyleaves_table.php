<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyleavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencyleaves', function (Blueprint $table) {
            $table->id();
            $table->integer('register_user_id');
            $table->integer('leave_type_id');
            $table->text('reason');
            $table->date('fromDate1');
            $table->date('toDate1');
            $table->integer('totalNoOfDays');
            $table->integer('pendingLeaves')->default(0);
            $table->integer('paidLeaves')->default(0);
            $table->integer('lost_of_pay')->default(0);
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
        Schema::dropIfExists('emergencyleaves');
    }
}
