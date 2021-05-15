<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {

            $apiKeyStatusConstant = collect(\App\Constants\ApiKeyStatusConstant::getConstants());
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', $apiKeyStatusConstant->toArray())->default($apiKeyStatusConstant->first());
            $table->string('hash');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
}
