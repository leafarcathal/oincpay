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
	 * Validates if all required fields were sent on request
	 * @param Request $request
	 * @return boolean;
	 */ 

	public function validateRequired($request)
	{
		$validator = Validator::make($request->all(), [
			'access_code' 			=> 'required|string|min:1|max:80',
			'amount' 				=> 'required',
			'receiver_identifier' 	=> 'required|string'
		]);

        if($validator->fails()){
        	return false;
        } else {
        	return true;
        }
	}

	/**
	 * Creates a new transaction
	 * @param AccessCode $accessCode,
	 * @param Wallet $senderWallet,
	 * @param Wallet $receiverWallet,
	 * @param string $amount,
	 * @return mixed Transaction or boolean false if it fails;
	 */ 

	public function create(AccessCode $accessCode, Wallet $senderWallet, Wallet $receiverWallet, $amount)
	{
		
		$transaction = Transaction::create([
            'user_id_sender' 		=> $senderWallet->user_id,
            'user_id_receiver' 		=> $receiverWallet->user_id,
            'wallet_id_sender' 		=> $senderWallet->id,
            'wallet_id_receiver' 	=> $receiverWallet->id,
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