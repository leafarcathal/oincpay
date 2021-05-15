<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\AccessCode;

class AccessCodeService
{

	/**
	 * Creates a new access_code for the logged user;
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

	/**
	 * Check if access code is valid;
	 * @param String access_code
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