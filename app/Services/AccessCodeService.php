<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\AccessCode;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AccessCodeService
{

	/**
	 * ACreates a new access_code for the logged user;
	 * @return mixed array() or bollean false if fails;
	 */ 

	public function generate()
	{
		$accessCode = AccessCode::create([
			'user_id' 		=> Auth::user()->id, 
			'valid_through' => Carbon::now()->add(10, 'minutes'),
			'access_code'	=> Str::random(60),
		]);

		if(!$accessCode){
			return false;
		} else {
			return [
				'access_code'	=> $accessCode->access_code,
			];
		}

	}
}