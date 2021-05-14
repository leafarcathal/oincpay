<?php

namespace App\Services;

use App\Models\Wallet;

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
			'description'		=> $wallet->description,
			'amount'			=> $wallet->amount
		];
		return $wallet;
	}

	/**
	 * Check if access code is valid;
	 * @param String access_code;
	 * @return mixed AccessCode $accessCode or boolean false if fails;
	 */ 

	public function check($access_code)
	{
		$accessCode = AccessCode::where('access_code', $access_code)->first();
		
		if(is_null($accessCode)){
			return false;
		}

		$now = Carbon::now();

		if($now->gt($accessCode->valid_through)){
			return false;
		} 
		return $accessCode;
	}
}