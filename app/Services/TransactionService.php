<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\AccessCode;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\User;

use App\Constants\TransactionStatusConstant;

class TransactionService
{

	/**
	 * Creates a new transaction
	 * @param AccessCode $accessCode,
	 * @param User $senderUser,
	 * @param User $receiverUser,
	 * @param string $amount,
	 * @return mixed Transaction or boolean false if it fails;
	 */ 

	public function create(AccessCode $accessCode, User $senderUser, User $receiverUser, $amount)
	{
		
		$transaction = Transaction::create([
            'user_id_sender' 		=> $senderUser->id,
            'user_id_receiver' 		=> $receiverUser->id,
            'wallet_id_sender' 		=> $senderUser->wallet->id,
            'wallet_id_receiver' 	=> $receiverUser->wallet->id,
            'status' 				=> TransactionStatusConstant::NOT_PAID,
            'uuid'	 				=> Str::random(20),
            'access_code'			=> $accessCode->access_code,
            'amount'				=> floatval($amount),
        ]);

        if(!$transaction){
        	return false;
        }

        return $transaction;
	}

}