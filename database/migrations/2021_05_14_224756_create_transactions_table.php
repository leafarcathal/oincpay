<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $transactionStatus = collect(\App\Constants\TransactionStatusConstant::getConstants());

            $table->id();
            $table->unsignedBigInteger('user_id_sender');
            $table->unsignedBigInteger('user_id_receiver');
            $table->unsignedBigInteger('wallet_id_sender');
            $table->unsignedBigInteger('wallet_id_receiver');
            $table->enum('status', $transactionStatus->toArray())->default($transactionStatus->last());
            $table->string('uuid');
            $table->string('access_code');
            $table->decimal('amount', $precision = 14, $scale = 2);

            $table->foreign('user_id_sender')->references('id')->on('users');
            $table->foreign('user_id_receiver')->references('id')->on('users');
            $table->foreign('wallet_id_sender')->references('id')->on('wallets');
            $table->foreign('wallet_id_receiver')->references('id')->on('wallets');
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
        Schema::dropIfExists('transactions');
    }
}
