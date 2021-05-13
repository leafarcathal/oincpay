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

            $userStatus = collect(\App\Constants\UserStatusConstant::getConstants());

            $table->id();
            $table->integer('user_group_id')->unsigned();
            $table->enum('status', $userStatus->toArray())->default($userStatus->first());
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nickname')->nullable();
            $table->string('document')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_group_id')->references('id')->on('user_groups');
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
