<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

use App\Models\Wallet;

class WalletService
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
		]);

        if($validator->fails()){
        	return false;
        } else {
        	return true;
        }

	}

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
}