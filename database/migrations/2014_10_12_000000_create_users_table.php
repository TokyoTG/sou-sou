<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->bigInteger('phone_number')->unique();
            $table->bigInteger('account_number')->nullable();
            $table->string('bank_name')->nullable();
            // $table->integer('groups_in')->nullable();
            $table->string('email')->unique();
            $table->string('role');
            $table->integer('group_times')->default(0);
            $table->integer('top_times')->default(0);
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
