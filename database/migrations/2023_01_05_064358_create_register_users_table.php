<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',100);
            $table->string('middle_name',100);
            $table->string('last_name',100);
            $table->string('email',250);
            $table->string('password',250);
            $table->string('phone_number',15);
            $table->string('gender');
            $table->string('user_role',100);
            $table->integer('pin');
            $table->string('mail_link',255);
            $table->string('secret_key',250)->default(0);
            $table->tinyInteger('is_twostep_active')->default(0);
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
        Schema::dropIfExists('register_users');
    }
}
