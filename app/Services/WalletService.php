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
			'wallet' => [
				'description'		=> $wallet->description,
				'amount'			=> $wallet->amount
			]
		];
		return $wallet;
	}
}