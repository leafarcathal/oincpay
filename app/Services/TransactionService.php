<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

use App\Models\Wallet;


class TransactionService
{

	/**
	 * Validates if all required fields were sent on request
	 * @param Request $request
	 * @return boolean;
	 */ 

	public function validateRequired($request){

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

}