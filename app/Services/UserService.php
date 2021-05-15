<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{

	/**
	 * Get user information based on document or e-mail. 
	 * @param  String $string
	 * @return boolean;
	 */ 

	public function getByEmailOrDocument($string)
	{
	 	if($this->getByEmail($string)){
	 		return $this->getByEmail($string);
	 	} else if($this->getByDocument($string)){
	 		return $this->getByDocument($string);
	 	} else {
	 		return false;
	 	}
	}

	/**
	 * Get user information based on email. 
	 * @param  String $email.
	 * @return User or boolean false if it fails;
	 */ 

	protected function getByEmail($email)
	{
		$user = User::where('email', Str::replace(['-','/'], '', $email))->first();
		if(is_null($user)){
			return false;
		}
		return $user;
	}

	/**
	 * Get user information based on document. 
	 * @param  String $document.
	 * @return User or boolean false if it fails;
	 */ 

	protected function getByDocument($document)
	{
		$user = User::where('document', Str::replace(['-','/','.','_'], '', $document))->first();
		if(is_null($user)){
			return false;
		}
		return $user;
	}
}