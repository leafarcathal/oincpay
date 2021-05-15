<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Wallet;
use App\Models\Transaction;

use App\Constants\ExternalServiceConstant;
use App\Constants\TransactionStatusConstant;

class WalletService
{

	/**
	 * Get wallet information by user;
	 * @param String user_id;
	 * @return array $wallet or boolean false if fails;
	 */ 

	public function getByUser($user_id)
	{
		$wallet = Wallet::where('user_id', $user_id)->first();
		if(is_null($wallet)){
			return false;
		}

		$wallet = [
			'wallet' => [
				'description'		=> $wallet->description,
				'amount'			=> floatval($wallet->amount)
			]
		];
		return $wallet;
	}

	/**
	 * Check if the user has the amount they're trying to transfer;
	 * @param String user_id;
	 * @param float amount;
	 * @return boolean;
	 */ 

	public function checkFunds($user_id, $amount)
	{
		$wallet = Wallet::where('user_id', $user_id)->first();
		if(is_null($wallet)){
			return false;
		}

		if(floatval($amount) > floatval($wallet->amount)){
			return false;
		}
		
		return true;
	}

	/**
	 * Attempt to transfer money between wallets;
	 * @param Transaction $transaction,
	 * @return Transaction of boolean false if fails;
	 */ 

	public function transfer(Transaction $transaction){

		DB::beginTransaction();
		$error = false;

		// Attempts to remove amount from sender's wallet

		$senderWallet = Wallet::find(intval($transaction->wallet_id_sender));
		$senderWallet->amount = (floatval($senderWallet->amount) - floatval($transaction->amount));
		if(!$senderWallet->save()){
			$error = true;
		}

		// Checks the status of an external service

		$response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
		
		if(!$response->successful()){
			$error = true;
		}

		if((!isset($response->json()['message'])) || ($response->json()['message'] != ExternalServiceConstant::AUTHORIZED)){
			$error = true;
		}

		// Attempts to add amount on receiver's wallet

		$receiverWallet = Wallet::find(intval($transaction->wallet_id_receiver));
		$receiverWallet->amount = (floatval($receiverWallet->amount) + floatval($transaction->amount));
		if(!$receiverWallet->save()){
			$error = true;
		}

		// Update the transaction status 

		if(!$transaction->update(['status' => TransactionStatusConstant::PAID])){
			$error = true;
		}

		// Check if there was an error above. If so, transaction will be rolled back.

		if($error){
			DB::rollback();
			return false;
		}

		DB::commit();
		return $transaction;

	}
}