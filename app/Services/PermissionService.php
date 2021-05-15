<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\AccessCode;
use App\Models\User;
use App\Models\Permission;

class PermissionService
{

	/**
	 * Get user group permission by access_code
	 * @param String $access_code 
	 * @return mixed array() or bollean false if fails;
	 */ 

	public function getByAccessCode($access_code)
	{
		$accessCode = AccessCode::where('access_code', $access_code)->first();

		if(!$accessCode){
			return false;
		}
		return $this->getByUser($accessCode->user_id);
	}

	/**
	 * Get user group permission by user id
	 * @param String $user_id 
	 * @return Permission or bollean false if fails;
	 */ 

	public function getByUser($user_id)
	{
		$user = User::find(intval($user_id));
		if(!$user){
			return false;
		}
		return $this->getByUserGroup($user->user_group_id);
	}

	/**
	 * Get user group permission by user group
	 * @param String $user_group_id 
	 * @return Permission or bollean false if fails;
	 */ 

	public function getByUserGroup($user_group_id)
	{
		return Permission::where('user_group_id', $user_group_id)->get();
	}
}